<?php


require_once(__DIR__."/php-gpg/libs/GPG.php");

define("GPG_PUB_KEY", "GPGPublicKey.asc");

class Scanner
{

    protected $initpath;
    protected $algo;
    protected $files;
    
    public function __construct( $initpath = "./", $algo='sha256')
    {
        $this->initpath = $initpath ;   
        $this->algo = $algo;
    }

    private function gpg_encrypt( $text )
    {
        $gpg = new GPG();
        try
        {
            $pub_key = new GPG_Public_Key( trim( file_get_contents( GPG_PUB_KEY ) ) );
        }catch( Exception $e)
        {
            die("Make sure that it's a valid gpg public key.");
            return False;
        }
        
        return $gpg->encrypt( $pub_key, $text , "0.0");
    }

    public function Scan()
    {
        $dirs = [ $this->initpath ];
        $i = 0;
        $all_files = [];
        
        while( True )
        {
            $files = scandir( $dirs[$i] );
            foreach( $files as $file )
            {
                if( $file == ".." || $file == "."){ continue; }
                
                $c_file = str_replace("//", "/", $dirs[$i]."/".$file);
                
                if( is_file( $c_file ) )
                {
                    $hash = hash_file( $this->algo, $c_file );
                    $all_files[ $c_file ] = $hash ;

                }else
                {
                    array_push( $dirs, $c_file );
                }
            }

            $i += 1;
            if( $i >= count( $dirs ) )
            {
                break;
            }
        }

        return $all_files;
    }

    public function Save( $filepath, $scan_obj )
    {
        $data = json_encode( $scan_obj );
        unset( $scan_obj );
        $enc_data = $this->gpg_encrypt( $data );
        unset( $data );

        file_put_contents( $filepath, $enc_data );

        return True;
    }
}

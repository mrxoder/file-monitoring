<?php

require_once(__DIR__."/php-gpg/libs/GPG.php");

define("GPG_PUB_KEY", "publicKey.asc");

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
        $pub_key = new GPG_Public_Key( trim( file_get_contents( GPG_PUB_KEY ) ) );
        return $gpg->encrypt( $pub_key, $text , "0.0");
    }

    public function scan()
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
                    array_push( $all_files, [ $c_file => $hash ]);

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

        var_dump( $all_files );

        
    }
}
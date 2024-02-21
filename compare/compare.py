import json
import sys, os


RED = "\033[31m"
GREEN = "\033[32m"
YELLOW = "\033[33m"
BLUE = "\033[34m"
WHITE = "\033[37m"

if not "linux" in sys.platform:
    RED = ""
    GREEN = ""
    YELLOW = ""
    BLUE = ""
    WHITE = ""

class Compare:
    def __init__(self, file_0, file_1):
        self.file_0 = file_0
        self.file_1 = file_1

        self._changed = []
        self._created = []
        self._deleted =[]

        self.__check()

    def __check( self ):
        try:
            json_0 = json.load( open(self.file_0) ) 
            json_1 = json.load( open(self.file_1) )
        except:
            print("Bad json.")
        
        for _file in json_1["files"]:
            if not _file in json_0["files"].keys():
                self._created.append( _file )
            else:
                if json_0["files"][ _file ] != json_1["files"][ _file ]:
                    self._changed.append( _file )

        for _file in json_0["files"]:
            if not _file in json_1["files"].keys():
                self._deleted.append( _file )


if len(sys.argv) < 3:
    print(WHITE)
    print("\n    Usage: "+sys.argv[0]+" <oldest scan result>  <newest scan result>")
else:
    if not os.path.exists( sys.argv[1] ):
       print(YELLOW+" "+sys.argv[1]+": "+RED+"No such file or directory"+WHITE)
       sys.exit()
    
    if not os.path.exists( sys.argv[2] ):
       print(YELLOW+" "+sys.argv[2]+": "+RED+"No such file or directory"+WHITE)
       sys.exit()

    comparison = Compare( sys.argv[1], sys.argv[2] )
    
    print(GREEN+f" Changed Files [{len(comparison._changed)}]:"+RED)
    for changed in comparison._changed:
        print(f"   {changed}")
    
    print(WHITE)
    

    print(GREEN+f" Deleted Files [{len(comparison._deleted)}]:"+YELLOW)
    for deleted in comparison._deleted:
        print( f"   {deleted}" )
    
    print(WHITE)
    

    print(GREEN+f" New Files [{len(comparison._created)}]:"+YELLOW)
    for _created in comparison._created:
        print( f"   {_created}" )
    
    print(WHITE)



        
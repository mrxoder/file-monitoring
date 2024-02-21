import json
import sys


class Compare:
    def __init__(self, file_0, file_1):
        self.file_0 = file_0
        self.file_1 = file_1
         
        self._changed = []
        self._created = []
        self._deleted =[]

    def check( self ):
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
    print("\n Usage: "+sys.argv[0]+" <oldest json scan result>  <newest json scan result>")
else:
    comparison = Compare( sys.argv[1], sys.argv[2] )  
            

        
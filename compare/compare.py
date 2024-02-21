import json


class Compare:
    def __init__(self, file_0, file_1):
        self.file_0 = file_0
        self.file_1 = file_1
         
        self._changed = []
        self._created = []
        self._deleted =[]

    def check( self ):
        json_0 = json.load( open(self.file_0) ) 
        json_1 = json.load( open(self.file_1) )

        for _file in json_1:
            if not json_0[ ]

        
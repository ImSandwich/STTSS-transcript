import pandas as pd
import sys

def main():
    excel_filepath = sys.argv[1]
    excel_file = pd.ExcelFile("uploads/" + excel_filepath)
    excel_book = {}
    for i in excel_file.sheet_names:
        excel_book[i] = excel_file.parse(i)
        print("{}:{}".format(i, stringify_db(excel_file.parse(i))))
        
    
def stringify_db(input_db):
    output = ""
    line = ""
    for entry in input_db.columns:
        line += str(entry) + ";"
    output += line + "|"
    for i in range(len(input_db.index)):
        line = ""
        row = input_db.iloc[i,:]
        for entry in row:
            line += str(entry) + ";"
        output += line + "|"
    return output


if __name__ == "__main__":
    main()
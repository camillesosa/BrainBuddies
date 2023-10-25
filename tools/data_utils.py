import csv
import time

with open('tools/SampleData.csv', 'r', encoding='utf-8-sig') as file:
    reader = csv.reader(file)
    for row in reader:
        time.sleep(3)
        print(row)

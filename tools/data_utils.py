import csv


data_stored = False
data = []

# Do not call this function, it is called automatically in this script
# Open SampleData file store data into data variable
def openSampleData():
    global data_stored

    try:
        with open('tools/SampleData.csv', 'r', encoding='utf-8-sig') as file:
            csv_reader = csv.reader(file)
            data = [row for row in csv_reader]
            data_stored = True
        return data
    except FileNotFoundError:
        print("File tools/SampleData.csv not found.")
        return []

# Returns a full row sample packet
def getSamplePacket():
    return data[0]

# Returns a cleaned up sample packet (first portion of data in the packet)
def getCleanedSamplePacket():
    packet = data[0]            # Value is an array
    packet_string = packet[0]   # Value is the string inside the array (full packet data)
    
    # Parse to get first portion of data
    start_index = packet_string.find("BrainBitSignalData(")
    end_index = packet_string.find(")")

    return packet_string[start_index:end_index + 1]


# Aquire data into data variable
if not data_stored:
    data = openSampleData()

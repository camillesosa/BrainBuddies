import csv
from sys import platform
import pickle


data_stored = False
data = []

file_path_MacOS = 'tools/SampleData.csv'
file_path_Windows = 'SampleData.csv'
file_path = ''

# Do not call this function, it is called automatically in this script
# Open SampleData file store data into data variable
def openSampleData():
    global data_stored

    # Check OS for file path
    if platform == "darwin":
        file_path = file_path_MacOS
    elif platform == "win32":
        file_path = file_path_Windows
    else:
        print("ERROR: Operating system not supported for file open")
        file_path = file_path_MacOS

    try:
        with open(file_path, 'r', encoding='utf-8-sig') as file:
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

def parseUserData(user_id)
    # Initialize variables to accumulate values
    o1_sum = 0
    o2_sum = 0
    t3_sum = 0
    t4_sum = 0
    sample_count = 0

    user_id = 'temp'
    in_filename = f"{user_id}_raw.pkl" # Will change to User ID specific file when connection to front end is made
    out_filename = f"user_data\{user_id}_parsed.pkl"
    #in_filename = "SampleData.pkl" # Comment in for debug purposes

    # Edit this in to print the data
    # with open(filename, 'rb') as file:
    #     data = pickle.load(file)
    #     print(data)
    #     while data:
    #         data = pickle.load(file)
    #         print(data)


    try:
        with open(in_filename, 'rb') as file: # Opens file in read binary mode
            data = pickle.load(file) # Will return one packet
            while data: # While data is still being read from the .pkl file
                o1_sum += sum(sample.O1 for sample in data) # Sum will add up all the values for o1 given for ONE packet and the will add that sum to a running total for O1
                o2_sum += sum(sample.O2 for sample in data)
                t3_sum += sum(sample.T3 for sample in data)
                t4_sum += sum(sample.T4 for sample in data)
                sample_count += len(data) # Will count the amount of samples given per packet (can be 2 4 or 6 samples per packet)
                data = pickle.load(file) # Load the new packet
    except FileNotFoundError:
        print(f"File '{in_filename}' not found.")
    except Exception as e:
        print(e) # Exists to notify when data can no longer be read

    # Calculate the averages
    if sample_count > 0:
        o1_avg = o1_sum / sample_count
        o2_avg = o2_sum / sample_count
        t3_avg = t3_sum / sample_count
        t4_avg = t4_sum / sample_count
        averages = [o1_avg, o2_avg, t3_avg, t4_avg]
        # Store the list of averages using pickle
        with open(out_filename, 'wb') as file:
            pickle.dump(averages, file)

        # Comment in for debug purposes
        # print(f"Average O1: {o1_avg}")
        # print(f"Average O2: {o2_avg}")
        # print(f"Average T3: {t3_avg}")
        # print(f"Average T4: {t4_avg}")
    else:
        print("No data available to calculate averages.")

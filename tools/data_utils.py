import csv
from sys import platform
import pickle
import math
import os
import json


data_stored = False
data = []

file_path_MacOS = 'tools/SampleData.csv'
file_path_Windows = 'SampleData.csv'
file_path = ''

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
    # Aquire data into data variable
    if not data_stored:
        data = openSampleData()

    return data[0]

# Returns a cleaned up sample packet (first portion of data in the packet)
def getCleanedSamplePacket():
    # Aquire data into data variable
    if not data_stored:
        data = openSampleData()

    packet = data[0]            # Value is an array
    packet_string = packet[0]   # Value is the string inside the array (full packet data)
    
    # Parse to get first portion of data
    start_index = packet_string.find("BrainBitSignalData(")
    end_index = packet_string.find(")")

    return packet_string[start_index:end_index + 1]


def parseUserData(user_id):
    # Initialize variables to accumulate values
    o1_sum = 0
    o2_sum = 0
    t3_sum = 0
    t4_sum = 0
    sample_count = 0

    user_id = 'temp'

    create_user_directory(user_id)  # Creating user directory if it has not been created
    in_filename = f"{user_id}_raw.pkl" # Will change to User ID specific file when connection to front end is made
    out_filename = os.path.join("user_data", user_id, f"{user_id}_parsed.pkl")
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

# User matching using euclidean distance ( user_data_x is a list for averages [O1, O2, T3, T4] )
def calculate_user_match(user_data_1, user_data_2):
    # Calculate difference between both users data
    o1_difference = user_data_1[0] - user_data_2[0] 
    o2_difference = user_data_1[1] - user_data_2[1]
    t3_difference = user_data_1[2] - user_data_2[2]
    t4_difference = user_data_1[3] - user_data_2[3]

    # Calculate euclidean distance using difference calculations 
    euclidean_distance = math.sqrt( (o1_difference)**2 + 
                                    (o2_difference)**2 +
                                    (t3_difference)**2 +
                                    (t4_difference)**2 )
    
    # lower distance = better match 
    return euclidean_distance

# Return list of subdirectories from a root directory
def get_subdirectories(root_dir):
    subdir = []

    # Go through each file/folder in the root directory
    for item in os.listdir(root_dir):
        # Check if the item is a sub-directory
        full_path = os.path.join(root_dir, item)
        if os.path.isdir(full_path):
            subdir.append(item)

    return subdir

# Returns data from pkl file (check for file exist done before function call)
def get_data_from_pkl(pkl_path):
    pkl_data = None

    with open(pkl_path, 'rb') as file:
            pkl_data = pickle.load(file)

    return pkl_data

# Create json file to save matches if not already created
def create_matches_json():
    path_to_json = os.path.join('user_data', 'user_matches.json')
    
    # Create empty json if doesnt exist
    if not os.path.exists(path_to_json):
        matches = {}

        # Write the empty dictionary to the file
        with open(path_to_json, 'w') as file:
            json.dump(matches, file)

# Loads existing matches from json and returns them as dictionary
def load_existing_matches():
    path_to_json = os.path.join('user_data', 'user_matches.json')
    matches = {}

    # Create empty json if doesnt exist
    if os.path.exists(path_to_json):
        with open(path_to_json, 'r') as file:
            matches = json.load(file)
    else:
        print("ERROR: JSON does not exists ", path_to_json)
        return None
    
    return matches

# Add a match to the json dictionary
def add_to_matches(matches, cur_user_id, another_user, euclidean_distance):
    # Check if cur_user_id is existing as a key
    if cur_user_id in matches:
        # The other user is being added or if already exists, euclidean is updated
        matches[cur_user_id][another_user] = euclidean_distance  # Add to list of users (matches)
    else:
        # Create a new dictionary for this user_id
        matches[cur_user_id] = {}
        # Add other user as a match
        matches[cur_user_id][another_user] = euclidean_distance


# Save the matches dictionary to the matches json
def save_matches_to_json(matches):
    path_to_json = os.path.join('user_data', 'user_matches.json')

    # Write the updated dictionary back to the file
    with open(path_to_json, 'w') as file:
        json.dump(matches, file, indent=4)

# Function will go through other users data to find matches for current user
def find_user_matches(current_user_id):
    root_directory = 'user_data'
    subdir = get_subdirectories(root_directory)
    
    current_user_data_path = os.path.join(root_directory, current_user_id, f'{current_user_id}_parsed.pkl')
    current_user_data = None
    
    create_matches_json()   # Create json file to save matches if not already created
    existing_matches = load_existing_matches()  # Load existing saved matches dict from json

    # Check if current user has parsed data
    if os.path.exists(current_user_data_path):
        # Save current user's data
        current_user_data = get_data_from_pkl(current_user_data_path)
    else:
        print("ERROR: Current user path, ", current_user_data_path, " not found.")
        return None
 
    # Loop through each subdir in user_data directory ( user_id is a subdirectory name )
    for other_user_id in subdir:
        # Create full path to user parsed data
        other_user_path = os.path.join(root_directory, other_user_id, f'{other_user_id}_parsed.pkl')

        # Run calculation to find matches
        if os.path.exists(other_user_path) and other_user_id != current_user_id:
            other_user_data = get_data_from_pkl(other_user_path) # get other user's data

            # Call function to calculate euclidean distance between both users
            euclidean_distance = calculate_user_match(current_user_data, other_user_data)

            # If criteria for a match is met and it is not a rejected match, add the match
            if euclidean_distance < 5 and not is_rejected_match(current_user_id, other_user_id):
                add_to_matches(existing_matches, current_user_id, other_user_id, euclidean_distance)

        elif other_user_id != current_user_id:
            print("ERROR: ", other_user_path, " not found.")

    # saves all changes back to user_matches.json
    save_matches_to_json(existing_matches) 

# Creating a new user directory, user_id is a string
def create_user_directory(user_id):
    path_to_user_dir = os.path.join('user_data', user_id)
    os.makedirs(path_to_user_dir, exist_ok=True)    # If directory already exists, it will not be replaced

#
#   Reject User utils
#

# Allowing a user to reject a match
def reject_match(user_id, user_to_reject_id):
    # Create json to save rejected matches if not already created
    create_rejected_matches_json() 

    # Load existing rejected matches from json
    rejected_matches = load_existing_rejected_matches()  

    # Add the new rejected matches to variable
    add_to_rejected_matches(rejected_matches, user_id, user_to_reject_id)

    # Saved rejected matches variable to json
    save_rejected_matches_to_json(rejected_matches)

    # Update matches json based on the rejection
    update_matches_from_reject(user_id, user_to_reject_id)

# Check rejected_matches.json to see if a user is rejected or other user rejected current user,return bool
def is_rejected_match(user1_id, user2_id):
    rejected_matches = load_existing_rejected_matches()
    if user2_id in rejected_matches.get(user1_id, []) or user1_id in rejected_matches.get(user2_id, []):
        return True
    else:
        return False

# Removes the match from both users    
def update_matches_from_reject(user1_id, user2_id):
    matches = load_existing_matches()

    # Check if user is a key
    if user1_id in matches:
        # Check if user to be removed is an existing value
        if user2_id in matches[user1_id]:
            matches[user1_id].pop(user2_id)
    
    # Check if user is a key
    if user2_id in matches:
        # Check if user to be removed is an existing value
        if user1_id in matches[user2_id]:
            matches[user2_id].pop(user1_id)
    
    save_matches_to_json(matches)



# Create json file to save rejected matches if not already created
def create_rejected_matches_json():
    path_to_json = os.path.join('user_data', 'rejected_matches.json')
    
    # Create empty json if doesnt exist
    if not os.path.exists(path_to_json):
        rejected_matches = {}

        # Write the empty dictionary to the file
        with open(path_to_json, 'w') as file:
            json.dump(rejected_matches, file)

# Loads existing rejected matches from json and returns them as dictionary
def load_existing_rejected_matches():
    path_to_json = os.path.join('user_data', 'rejected_matches.json')
    rejected_matches = {}

    # Create empty json if doesnt exist
    if os.path.exists(path_to_json):
        with open(path_to_json, 'r') as file:
            rejected_matches = json.load(file)
    else:
        print("ERROR: JSON does not exists ", path_to_json)
        return None
    
    return rejected_matches

# Add a rejected_match to the json dictionary
def add_to_rejected_matches(rejected_matches, cur_user_id, rejected_user):
    # Check if cur_user_id is existing as a key
    if cur_user_id in rejected_matches:
        # Check if rejection already exists
        if rejected_user not in rejected_matches[cur_user_id]:
            # The other user is being added or if exists nothing changes
            rejected_matches[cur_user_id].append(rejected_user)
    else:
        # Add other user as a rejected_match
        rejected_matches[cur_user_id] = [rejected_user]

# Save the rejected matches dictionary to the matches json
def save_rejected_matches_to_json(rejected_matches):
    path_to_json = os.path.join('user_data', 'rejected_matches.json')

    # Write the updated dictionary back to the file
    with open(path_to_json, 'w') as file:
        json.dump(rejected_matches, file, indent=4)
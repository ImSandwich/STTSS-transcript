import sys
import os
import matplotlib.pyplot as plt
#%matplotlib inline
import random
from sklearn.datasets import load_digits
from sklearn import ensemble
import pylab as pl 
from PIL import Image
import numpy as np
import time

data_list = []
LETTER_WIDTH, LETTER_HEIGHT = 28,28
LEARNING_POPULATION = 10000
VALIDATION_POPULATION = 2000
#corresponding_vowel = ['Rest', 'A', 'I', 'U', 'E', 'O']

def crop(pth, name, width, height):
    im = Image.open(os.path.join(pth, name))
    global data_list
    data_list = []
    print(os.path.join(pth,name))
    total_width, total_height = im.width, im.height
    for i in range(0, total_height, height):
        data_list.append([])
        for j in range(0, total_width, width):
            box = (j,i, j+width, i+height)
            a = im.crop(box)
            a = a.resize((LETTER_WIDTH, LETTER_HEIGHT), Image.ANTIALIAS)
            data_list[len(data_list)-1].append(reshape(sparse_matrix(a)))

            

def main():
    '''
    pth = input("Training directory: ")
    training_img = input("Training images: ")
    training_label = input("Training labels: ")
    validation_img = input("Validation images: ")
    validation_label = input("Validation labels: ")
    '''

    pth = "C:\\Users\\m7720\\Documents\\My Codes\\number_detection"
    training_img = "train-images.idx3-ubyte"
    training_label = "train-labels.idx1-ubyte"
    validation_img = "t10k-images.idx3-ubyte"
    validation_label = "t10k-labels.idx1-ubyte"

    data_set = idx_image_reader(os.path.join(pth, training_img), LEARNING_POPULATION)
    label_set = idx_label_reader(os.path.join(pth, training_label), LEARNING_POPULATION)
    validation_data_set = idx_image_reader(os.path.join(pth, validation_img), VALIDATION_POPULATION)
    validation_label_set = idx_label_reader(os.path.join(pth, validation_label), VALIDATION_POPULATION)
    '''
    #Define variables
    n_samples = len(digits.images)
    x = digits.images.reshape((n_samples, -1))
    y = digits.target

    '''
    '''
    learning_population = 1000
    validation_population = 200
    #create random indices
    sample_index = random.sample(range(len(data_set)), learning_population)
    valid_index = random.sample(range(len(validation_data_set)), validation_population)
    

    #sample & validation images
    sample_images = [x[i] for i in sample_index]
    valid_images = [x[i] for i in valid_index]

    #sample & validation targets
    sample_target = [y[i] for i in sample_index]
    valid_target = [y[i] for i in valid_index]
    '''
    #Using the random tree classifier
    classifier = ensemble.RandomForestClassifier()

    #Fit model with sample data
    classifier.fit(data_set, label_set)
    
    score=classifier.score(validation_data_set, validation_label_set)
    print("Random Tree Classifier:\n")
    print("Score\t" + str(score))

    while True:
        pth = input("Score directory: ")
        name = input("Score name: ")
        grid_width, grid_height = input("Grid size: ").split(',')
        grid_width = int(grid_width)
        grid_height = int(grid_height)

        crop(pth, name, grid_width, grid_height)

        for row in data_list:
            line = ""
            for pix in row:
                line += str(classifier.predict([pix]))
            print(line)
    #print "You tried to analyze " + str(sys.argv[1])

'''
def lipreading():
    pth = input("Directory: ")
    name = input("Name: ")
    crop(pth, name, 99, 79)

    classifier = ensemble.RandomForestClassifier()
    sample_index = random.sample(range(len(data_list)), int(len(data_list)/10*9))
    valid_index = [i for i in range(len(data_list)) if i not in sample_index]

    data_target = []
    data_img = []
    for target, img in data_list:
        data_target.append(target)
        data_img.append(reshape(sparse_matrix(img)))
    
    sample_img = [data_img[i] for i in sample_index]
    sample_target = [data_target[i] for i in sample_index]

    valid_img = [data_img[i] for i in valid_index]
    valid_target = [data_target[i] for i in valid_index]

    classifier.fit(sample_img, sample_target)
    score = classifier.score(valid_img, valid_target)
    print("Random Tree Classifier:\n")
    print("Score:\t{}".format(score))

    while True:
        user_input = input("Image to read: ")
        answer = classifier.predict([reshape(sparse_matrix(Image.open(os.path.join(pth, user_input))))])
        print(corresponding_vowel[int(answer)])
'''

def sparse_matrix(img_input):
    row,column = img_input.height, img_input.width
    img_array = np.asarray(img_input)
    output = [None]*row

    for y in range(row):
        output[y] = []
        for x in range(column):
            summ = 0
            summ += img_array[y][x][0]
            summ += img_array[y][x][1]
            summ += img_array[y][x][2]
            summ /= 3
            summ = 255 - summ
            output[y].append(int(summ))
    
    return output



def reshape(img_array):
    output= []
    for row in img_array:
        output.extend(row)
    return output

data_set = []
validation_data_set = []
label_set = []
validation_label_set = []

def idx_image_reader(pth, max):
    file = open(pth, 'rb')
    line = ""
    file.read(16)
    image_count = 28*28
    current_count = 0
    array = []
    array.append([])


    line = file.read(image_count*max)

    for char in line:
        if current_count >= image_count:
            current_count = 0
            array.append([])
        array[len(array)-1].append((int('{0:3d}'.format(char))))
        current_count += 1
        
            
    return array
        

def idx_label_reader(pth, max):
    file = open(pth, 'rb')
    line = ""
    file.read(8)
    array = []

    line = file.read(max)

    for char in line:
        array.append(int('{0:3d}'.format(char)))

    return array

        

if __name__ == "__main__":
    main()
    
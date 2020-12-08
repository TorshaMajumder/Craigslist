DROP DATABASE wpl_final_project;
CREATE DATABASE wpl_final_project;
USE wpl_final_project;

CREATE TABLE Category (
    Category_ID int NOT NULL AUTO_INCREMENT,
    CategoryName varchar(32) NOT NULL,
    PRIMARY KEY (Category_ID)
);

CREATE TABLE Region (
    Region_ID int NOT NULL AUTO_INCREMENT,
    RegionName varchar(32) NOT NULL,
    PRIMARY KEY (Region_ID)
);

CREATE TABLE Location (
    Location_ID int NOT NULL AUTO_INCREMENT,
    Region_ID int NOT NULL,
    LocationName varchar(32) NOT NULL,
    PRIMARY KEY (Location_ID),
    FOREIGN KEY (Region_ID) REFERENCES Region(Region_ID)
);

CREATE TABLE SubCategory (
    SubCategory_ID int NOT NULL AUTO_INCREMENT,
    Category_ID int NOT NULL,
    SubCategoryName varchar(32) NOT NULL,
    PRIMARY KEY (SubCategory_ID),
    FOREIGN KEY (Category_ID) REFERENCES Category(Category_ID)
);

CREATE TABLE Posts (
    Post_ID int NOT NULL AUTO_INCREMENT,
    Title varchar(32) NOT NULL,
    Price decimal(8, 2) NOT NULL,
    Description varchar(255) NOT NULL,
    Email varchar(60) NOT NULL,
    Agreement boolean NOT NULL,
    TimeStamp timestamp NOT NULL,
    Image_1 blob,
    Image_2 blob,
    Image_3 blob,
    Image_4 blob,
    SubCategory_ID int NOT NULL,
    Location_ID int NOT NULL,
    PRIMARY KEY (Post_ID),
    FOREIGN KEY (SubCategory_ID) REFERENCES SubCategory(SubCategory_ID),
    FOREIGN KEY (Location_ID) REFERENCES Location(Location_ID)
);

CREATE TABLE Users (
    ID int NOT NULL AUTO_INCREMENT,
    Username varchar(32) NOT NULL,
    Password varchar(32) NOT NULL,
    Email varchar(60) NOT NULL,
    PRIMARY KEY (ID)
);

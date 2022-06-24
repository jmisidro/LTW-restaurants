
/*******************************************************************************
   Restaurant Database - Version 1.0
   Script: restaurant.sql
   Description: Creates and populates the Restaurant database.
   DB Server: Sqlite3
   Author: José Miguel Isidro
   Developed during LTW classes @FEUP - 2021/2022
********************************************************************************/

PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS Restaurant;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Owner;
DROP TABLE IF EXISTS Dish;
DROP TABLE IF EXISTS FavRestaurants;
DROP TABLE IF EXISTS FavDishes;
DROP TABLE IF EXISTS Orders;
DROP TABLE IF EXISTS OrdersDish;
DROP TABLE IF EXISTS Reservation;
DROP TABLE IF EXISTS Review;
DROP TABLE IF EXISTS ReviewComments;


/*******************************************************************************
   Create Tables
********************************************************************************/

CREATE TABLE Restaurant
(
    RestaurantId INTEGER  NOT NULL,
    Name NVARCHAR(160)  NOT NULL,
    OwnerId INTEGER  NOT NULL,
    Address NVARCHAR(70),
    Category NVARCHAR(20),
    CONSTRAINT PK_Restaurant PRIMARY KEY  (RestaurantId),
    FOREIGN KEY (OwnerId) REFERENCES Owner (OwnerId)
		ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE User
(
    UserId INTEGER  NOT NULL,
    Name NVARCHAR(160),
    PhoneNumber NVARCHAR(12),
    Address NVARCHAR(60),
    Username NVARCHAR(60) NOT NULL UNIQUE,
    Email NVARCHAR(60) NOT NULL UNIQUE,
    Password NVARCHAR(40) NOT NULL,
    CONSTRAINT PK_User PRIMARY KEY  (UserId)
);

CREATE TABLE Owner
(
    OwnerId INTEGER  NOT NULL,
    Name NVARCHAR(160),
    PhoneNumber NVARCHAR(12),
    Username NVARCHAR(60) NOT NULL UNIQUE,
    Email NVARCHAR(60) NOT NULL UNIQUE,
    Password NVARCHAR(40) NOT NULL,
    CONSTRAINT PK_Owner PRIMARY KEY  (OwnerId)
);

CREATE TABLE Dish
(
    DishId INTEGER  NOT NULL,
    RestaurantId INTEGER NOT NULL,
    Name NVARCHAR(160),
    Description NVARCHAR(200),
    Price REAL,
    Category NVARCHAR(20),
    CONSTRAINT PK_Dish PRIMARY KEY  (DishId)
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId)
		ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE FavRestaurants
(
    UserId INTEGER  NOT NULL,
    RestaurantId INTEGER  NOT NULL,
    FOREIGN KEY (UserId) REFERENCES User (UserId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId)
		ON DELETE CASCADE ON UPDATE CASCADE,
   CONSTRAINT PK_FavRestaurants PRIMARY KEY  (UserId, RestaurantId)
);

CREATE TABLE FavDishes
(
    UserId INTEGER  NOT NULL,
    DishId INTEGER  NOT NULL,
    FOREIGN KEY (UserId) REFERENCES User (UserId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (DishId) REFERENCES Dish (DishId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
   CONSTRAINT PK_FavDishes PRIMARY KEY  (UserId, DishId)
);

CREATE TABLE Review
(
    ReviewId INTEGER  NOT NULL,
    RestaurantId INTEGER  NOT NULL,
    UserId INTEGER NOT NULL,
    Rating INTEGER NOT NULL CHECK (Rating in (1, 2, 3, 4, 5)),
    Comment NVARCHAR(470),
    Date DATE NOT NULL,
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (UserId) REFERENCES User (UserId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
   CONSTRAINT PK_Review PRIMARY KEY  (ReviewId)
);

CREATE TABLE Orders
(
    OrderId INTEGER  NOT NULL,
    RestaurantId INTEGER  NOT NULL,
    UserId INTEGER NOT NULL,
    Total REAL NOT NULL,
    Status NVARCHAR(20) CHECK (Status in ('preparing', 'delivery', 'completed', 'canceled')),
    Date DATE NOT NULL,
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (UserId) REFERENCES User (UserId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
   CONSTRAINT PK_Order PRIMARY KEY(OrderId)
);

CREATE TABLE OrdersDish
(
    OrderId INTEGER  NOT NULL,
    DishId INTEGER  NOT NULL,
    Quantity INTEGER NOT NULL,
    FOREIGN KEY (OrderId) REFERENCES Orders (OrderId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (DishId) REFERENCES Dish (DishId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
   CONSTRAINT PK_OrderDish PRIMARY KEY (OrderId, DishId)
);


CREATE TABLE Reservation
(
    ReservationId INTEGER  NOT NULL,
    UserId INTEGER  NOT NULL,
    RestaurantId INTEGER  NOT NULL,
    Quantity INTEGER NOT NULL,
    Status NVARCHAR(20) CHECK (Status in ('active', 'expired', 'canceled')),
    Datetime TEXT NOT NULL UNIQUE,
    FOREIGN KEY (UserId) REFERENCES User (UserId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId) 
		ON DELETE CASCADE ON UPDATE CASCADE,
   CONSTRAINT PK_Reservation PRIMARY KEY (ReservationId)
);

CREATE TABLE ReviewComments
(
    CommentId INTEGER NOT NULL,
    ReviewId INTEGER  NOT NULL,
    RestaurantId INTEGER  NOT NULL,
    Comment NVARCHAR(470) NOT NULL,
    date DATE NOT NULL,
    FOREIGN KEY (ReviewId) REFERENCES Review (ReviewId) 
		ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (RestaurantId) REFERENCES Restaurant (RestaurantId) 
		ON DELETE NO ACTION ON UPDATE NO ACTION,
   CONSTRAINT PK_ReviewComments PRIMARY KEY (CommentId)
);
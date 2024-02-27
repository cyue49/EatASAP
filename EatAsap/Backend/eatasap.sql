/* ============== CREATING AND USING DATABASE ============== */
/* DROP DATABASE IF EXISTS id21924858_eatasap; */

CREATE DATABASE IF NOT EXISTS id21924858_eatasap;

USE id21924858_eatasap; 


/* ============== CREATING TABLES ============== */
/*Contact Us*/
 CREATE TABLE contact_submissions (
    submission_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(255),
    message TEXT NOT NULL
);


/* User */
CREATE TABLE user (
user_id INT NOT NULL UNIQUE AUTO_INCREMENT,
first_name VARCHAR(30) NOT NULL,
last_name VARCHAR(30) NOT NULL,
email VARCHAR(50) NOT NULL UNIQUE,
user_password VARCHAR(100) NOT NULL,
phone_number VARCHAR(13) NOT NULL UNIQUE,
user_address VARCHAR(255),
user_role VARCHAR(20) NOT NULL, /*owner-customer*/
PRIMARY KEY(user_id)
);


-- Order Entity
CREATE TABLE payment (
    payment_id INT NOT NULL UNIQUE AUTO_INCREMENT,
    user_id INT NOT NULL UNIQUE,
    payment_method VARCHAR(20) NOT NULL,
    card_number VARCHAR(16) NOT NULL,
    cvv INT NOT NULL,
    expiration_date DATE NOT NULL,
    PRIMARY KEY (payment_id),
    FOREIGN KEY (user_id) REFERENCES user (user_id)
);

CREATE TABLE order_cart (
    cart_id INT NOT NULL UNIQUE AUTO_INCREMENT,
    cart_subtotal FLOAT NOT NULL DEFAULT 0, /* before tax */
    PRIMARY KEY (cart_id)
);

CREATE TABLE orders (
    order_id INT NOT NULL UNIQUE AUTO_INCREMENT,
    cart_id INT NOT NULL UNIQUE,
    user_id INT, 
    order_total FLOAT NOT NULL,
    order_datetime DATETIME,
    order_number INT,
    order_status VARCHAR(20) DEFAULT "incomplete",
    PRIMARY KEY (order_id), 
    FOREIGN KEY (cart_id) REFERENCES order_cart (cart_id),
    FOREIGN KEY (user_id) REFERENCES user (user_id)
);

-- For Reataurant Entity
-- Create Business_Type table
CREATE TABLE business_type (
    business_type_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    business_type_name VARCHAR(255) UNIQUE NOT NULL
);

-- Create Restaurant table
CREATE TABLE restaurant (
    restaurant_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_id INT UNIQUE NOT NULL,                          -- one-to-one relationship with user table
    restaurant_name VARCHAR(255) UNIQUE NOT NULL,
    logo_url VARCHAR(255),
    business_type_id INT NOT NULL,
    brand_name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    website VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    FOREIGN KEY (business_type_id) REFERENCES business_type(business_type_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id)
);

-- Create Menu Categories table
CREATE TABLE menu_categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    category_name VARCHAR(255) UNIQUE NOT NULL
);

-- Create Menu_items table
CREATE TABLE menu_items (
    menu_item_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    restaurant_id INT NOT NULL,
    category_id INT NOT NULL,
    item_name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    picture_url VARCHAR(255),
    item_status TINYINT NOT NULL DEFAULT 1,    -- 1: Active, 0: Inactive, TINYINT: 1 byte only
    FOREIGN KEY (restaurant_id) REFERENCES restaurant(restaurant_id),
    FOREIGN KEY (category_id) REFERENCES menu_categories(category_id),
    CONSTRAINT UNIQUE (restaurant_id, item_name)
);

-- For Order Entity

CREATE TABLE cart_item (
    cart_item_id INT NOT NULL UNIQUE AUTO_INCREMENT,
    cart_id INT NOT NULL,
    menu_item_id INT NOT NULL,
    quantity INT NOT NULL,
    PRIMARY KEY (cart_item_id), 
    FOREIGN KEY (cart_id) REFERENCES order_cart (cart_id),
    FOREIGN KEY (menu_item_id) REFERENCES menu_items (menu_item_id)
);

CREATE TABLE temporary_order_user (
    temp_user_id INT NOT NULL UNIQUE AUTO_INCREMENT,
    order_id INT NOT NULL UNIQUE,
    first_name VARCHAR(20) NOT NULL,
    last_name VARCHAR(20) NOT NULL,
    phone VARCHAR(10) NOT NULL,
    email VARCHAR(50) NOT NULL,
    payment_method VARCHAR(20) NOT NULL,
    card_number VARCHAR(16) NOT NULL,
    cvv INT NOT NULL,
    expiration_date DATE NOT NULL,
    PRIMARY KEY (temp_user_id),
    FOREIGN KEY (order_id) REFERENCES orders (order_id)
);



-- For Restaurant Entity
-- Create Ingredient table
CREATE TABLE ingredient (
    ingredient_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    ingredient_name VARCHAR(255) UNIQUE NOT NULL,
    energy DECIMAL(10, 2)
);

-- Create Item_ingredients table
CREATE TABLE item_ingredients (
    item_ingredient_id INT PRIMARY KEY AUTO_INCREMENT,
    menu_item_id INT NOT NULL,               
    ingredient_id INT NOT NULL,
    quantity INT,
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(menu_item_id),
    FOREIGN KEY (ingredient_id) REFERENCES ingredient(ingredient_id),
    CONSTRAINT UNIQUE (menu_item_id, ingredient_id)
);

-- Create Plans table
CREATE TABLE plans (
    plan_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    plan_name VARCHAR(255) UNIQUE NOT NULL,
    plan_price DECIMAL(10, 2)
);

-- Create Restaurant_plans table
CREATE TABLE restaurant_plans (
    restaurant_plans_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    restaurant_id INT,
    plan_id INT,
    payment_id INT,
    starting_date DATE,
    end_date DATE,
    plan_status TINYINT NOT NULL,   -- 1: Active, 0: Inactive, TINYINT: 1 byte only
    FOREIGN KEY (restaurant_id) REFERENCES restaurant(restaurant_id),
    FOREIGN KEY (plan_id) REFERENCES plans(plan_id),
    FOREIGN KEY (payment_id) REFERENCES payment(payment_id)
);


-- Insert data into business_type table
INSERT INTO business_type (business_type_name) VALUES 
('Fast Food'),
('Casual Dining'),
('Fine Dining'),
('Cafe'),
('Bakery'),
('Food Truck'),
('Buffet'),
('Pop-up Restaurant'),
('Family Style'),
('Bistro'),
('Pizzeria'),
('Steakhouse'),
('Diner'),
('Pub'),
('Deli'),
('Theme Restaurant'),
('Sea Food Restaurant'),
('Vegetarian / Vegan'),
('Ethnic Restaurant'),
('Fast Casual');

INSERT INTO ingredient (ingredient_name, energy)
VALUES 
    ('Salmon', 220),
    ('Chicken', 180),
    ('Beef', 250),
    ('Pasta', 200),
    ('Shrimp', 150),
    ('Tofu', 120),
    ('Rice', 180),
    ('Pork', 220),
    ('Lamb', 280),
    ('Quinoa', 160),
    ('Tomatoes', 20),
    ('Spinach', 10),
    ('Artichokes', 30),
    ('Mozzarella Cheese', 100),
    ('Avocado', 150),
    ('Garlic Bread', 80),
    ('Hummus', 70),
    ('Bruschetta', 90),
    ('Stuffed Mushrooms', 110),
    ('Chocolate', 150),
    ('Apples', 80),
    ('Strawberries', 50),
    ('Bananas', 90),
    ('Vanilla Ice Cream', 120),
    ('Peanut Butter', 200),
    ('Whipped Cream', 70),
    ('Caramel Sauce', 180),
    ('Raspberries', 40),
    ('Blueberries', 60);

-- Insert data into menu_categories table
INSERT INTO menu_categories (category_name) VALUES 
('Main Dishes'),
('Appetizers'),
('Desserts'),
('Beverages');

-- Insert data into plans table
INSERT INTO plans (plan_name, plan_price) VALUES 
('Basic', 0.00),
('Standard', 10.00),
('Premium', 20.00);

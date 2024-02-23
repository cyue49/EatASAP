/* ============== CREATING AND USING DATABASE ============== */
/* DROP DATABASE IF EXISTS eatasap; */

CREATE DATABASE eatasap;

USE eatasap; 


/* ============== CREATING TABLES ============== */
/*Contact Us*/
 

/* User */
CREATE TABLE eatAsap_user (
user_id INT NOT NULL UNIQUE PRIMARY KEY,
firstName VARCHAR(30) NOT NULL,
lastName VARCHAR(30) NOT NULL,
email VARCHAR(50) NOT NULL UNIQUE,
phoneNumber INT NOT NULL UNIQUE
);

/* Restaurant */


/* Order */
CREATE TABLE payment (
    payment_id INT NOT NULL UNIQUE,
    user_id INT NOT NULL UNIQUE,
    payment_method VARCHAR(20) NOT NULL,
    card_number VARCHAR(16) NOT NULL,
    cvv INT NOT NULL,
    expiration_date DATE NOT NULL,
    PRIMARY KEY (payment_id),
    FOREIGN KEY (user_id) REFERENCES user (user_id)
);

CREATE TABLE order_cart (
    cart_id INT NOT NULL UNIQUE,
    cart_subtotal FLOAT NOT NULL DEFAULT 0, /* before tax */
    PRIMARY KEY (cart_id)
);

CREATE TABLE orders (
    order_id INT NOT NULL UNIQUE,
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


CREATE TABLE cart_item (
    cart_item_id INT NOT NULL UNIQUE,
    cart_id INT NOT NULL,
    menu_item_id INT NOT NULL UNIQUE,
    quantity INT NOT NULL,
    PRIMARY KEY (cart_item_id), 
    FOREIGN KEY (cart_id) REFERENCES order_cart (cart_id),
    FOREIGN KEY (menu_item_id) REFERENCES menu_items (menu_item_id)
);

CREATE TABLE temporary_order_user (
    temp_user_id INT NOT NULL UNIQUE,
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
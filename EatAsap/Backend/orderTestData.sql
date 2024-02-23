/* ============== DATA FOR TESTING ============== */
USE eatasap; 

-- user
INSERT INTO user(user_id, first_name, last_name, email, phone_number, user_password, user_role) VALUES
(1, "Jasmine", "Tea", "jasmine@teamail.com", "5141234567", "password", "customer"),
(2, "Green", "Tea", "green@teamail.com", "5141112233", "password", "owner");

-- order entity
INSERT INTO payment(payment_id, user_id, payment_method, card_number, cvv, expiration_date) VALUES
(1, 1, "Visa", "1234567891234567", 123, "2026-01-01"),
(2, 2, "MasterCard", "1111222233334444", 321, "2026-01-01");

INSERT INTO order_cart(cart_id, cart_subtotal) VALUES
(1, 23.45), 
(2, 28.00),
(3, 30.00);

INSERT INTO orders(order_id, cart_id, user_id, order_total, order_datetime, order_number, order_status) VALUES
(1, 1, 1, 23.45, "2023-02-25 15:02:11", 153, "completed"),
(2, 2, NULL, 28.00, "2023-03-25 15:02:11", 111, "completed");

--  Restaurant 
INSERT INTO restaurant(restaurant_id, user_id, restaurant_name, business_type_id, brand_name, address, phone_number, website, email) VALUES
(1, 2, "Green Salad", 2, "Green Salad Inc.", "153 Salad Street", "5141234567", "greensalad.com", "greensalad@gmail.com");

-- Menu Items
INSERT INTO menu_items (menu_item_id, restaurant_id, category_id, item_name, price, item_status) VALUES 
(1, 1, 1, "Tomato salad", 5.50, 1), 
(2, 1, 1, "Green peas salad", 3.45, 1), 
(3, 1, 1, "Vegetable soup", 4.25, 1);

-- Cart Items
INSERT INTO cart_item(cart_item_id, cart_id, menu_item_id, quantity) VALUES
(1, 3, 1, 3), 
(2, 3, 2, 2), 
(3, 3, 3, 1);

INSERT INTO temporary_order_user(temp_user_id, order_id, first_name, last_name, phone, email, payment_method, card_number, cvv, expiration_date) VALUES
(1, 2 , "Oolong", "Tea", "5145145145", "oolong@chamail.com", "MasterCard", "1111222233334444", 999, "2026-01-01");


/* ============== DATA FOR TESTING ============== */
USE eatasap; 


INSERT INTO user (user_id, first_name, last_name, email, user_password, phone_number, user_role)
VALUES 
    (1, "John", "Doe", "john@example.com", "password", 12345, "owner"),
    (2, "Alice", "Smith", "alice@example.com", "password", 98765, "owner"),
    (3, "Michael", "Johnson", "michael@example.com", "password", 55512, "owner"),
    (4, "Emily", "Brown", "emily@example.com", "password", 9998, "owner"),
    (5, "Jasmine", "Tea", "jasmine@example.com", "password", "5141234567", "customer");

INSERT INTO restaurant (user_id, restaurant_name, business_type_id, brand_name, address, phone_number, website, email)
VALUES 
	(1, "Pizza Pizza", 11, "Pizza Palace Inc.", "123 Main Street", "555-1234", "www.pizzapalace.com", "info@pizzapalace.com"),
    (2, "Burger Barn", 1, "Burger Barn Inc.", "456 Oak Avenue", "555-5678", "www.burgerbarn.com", "info@burgerbarn.com"),
    (3, "Sushi Spot", 17, "Sushi Spot Inc.", "789 Elm Road", "555-9012", "www.sushispot.com", "info@sushispot.com"),
    (4, "Taco Tavern", 20, "Taco Tavern Inc.", "101 Pine Lane", "555-3456", "www.tacotavern.com", "info@tacotavern.com");

INSERT INTO menu_items (restaurant_id, category_id, item_name, price, picture_url, item_status)
VALUES 
    (1, 1, 'Margherita Pizza', 9.99, '../../assets/pictures/PlatesPictures/plate4.jpg', 1),
    (1, 1, 'Pepperoni Pizza', 11.99, '../../assets/pictures/PlatesPictures/plate5.jpg', 1),
    (1, 2, 'Classic Cheeseburger', 8.99, 'https://example.com/cheeseburger.jpg', 1),
    (2, 2, 'Bacon Burger', 10.99, '../../assets/pictures/PlatesPictures/plate6.jpg', 1),
    (1, 3, 'California Roll', 12.99, '../../assets/pictures/PlatesPictures/plate4.jpg', 1);

INSERT INTO item_ingredients (menu_item_id, ingredient_id, quantity)
VALUES 
    (1, 1, 2),  -- 2 units of ingredient with ID 1 for menu item with ID 1
    (1, 2, 1),  -- 1 unit of ingredient with ID 2 for menu item with ID 1
    (2, 3, 1),  -- 1 unit of ingredient with ID 3 for menu item with ID 2
    (2, 4, 1),  -- 1 unit of ingredient with ID 4 for menu item with ID 2
    (3, 5, 2);  -- 2 units of ingredient with ID 5 for menu item with ID 3

INSERT INTO payment(payment_id, user_id, payment_method, card_number, cvv, expiration_date) 
VALUES
(1, 5, "Visa", "1234567891234567", 123, "2026-01-01");

INSERT INTO order_cart(cart_id, cart_subtotal) 
VALUES
(1, 23.45), 
(2, 28.00),
(3, 30.00);

INSERT INTO orders(order_id, cart_id, user_id, order_total, order_datetime, order_number, order_status) 
VALUES
(1, 1, 5, 23.45, "2023-02-25 15:02:11", 153, "completed"),
(2, 2, NULL, 28.00, "2023-03-25 15:02:11", 111, "completed");

INSERT INTO cart_item(cart_item_id, cart_id, menu_item_id, quantity) 
VALUES
(1, 1, 1, 2), 
(2, 1, 2, 2), 
(3, 1, 3, 2),
(4, 3, 1, 3), 
(5, 3, 2, 2), 
(6, 3, 3, 1);

INSERT INTO temporary_order_user(temp_user_id, order_id, first_name, last_name, phone, email, payment_method, card_number, cvv, expiration_date) 
VALUES
(1, 2 , "Oolong", "Tea", "5145145145", "oolong@example.com", "MasterCard", "1111222233334444", 999, "2026-01-01");


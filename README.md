# ChipShop
Online electronics store. Website using PHP scripting language. 

## Basic user functionality
- Convenient interface;
- Browse products by category;
-	Receiving e-mail messages about order status;
-	View reviews;
-	Add reviews;
-	Add and manage products in the cart;
-	Search by product name;
-	Filtering goods by: date, sales, best estimate, number of reviews, price;
-	Receive similar products;
-	Infinite scrolling;
-	Add product to favorites for subscription to discounts;
-	Account Management;
-	Avatar profile for reviews;
-	Automatic image cropping;
-	Forgotten password recovery via email;
-	Indexing in the database for quick search.

## Basic admin functionality
- Convenient admin panel;
-	Adding categories;
-	Creating and editing products;
-	Automatic image cropping;
-	Adding discounts for certain products;
-	User and Moderator Management;
-	Reviews Management.

### Admin can
-	Ban users;
-	Remove reviews;
-	Create, edit and delete supercategories, categories and subcategories. Deleting also deletes all child categories, which makes them invisible to users.;
-	Manage subcategory specifications;
-	Manage goods and promotions;
-	Manage orders.

### Moderator can
-	Can manage goods and orders
-	Remove reviews.

## Documentation
- Admin - role 3;
- Moderator - role 2;
- User - role 1;
- To recover a password, check token is used. Tokken expires in 10 minutes;
-	Email notifications for purchases, order status changes and promotions for users who have added the product to their favorites;
-	Uploaded images should be no more than 5 MB of jpg, jpeg, gif or png format;
-	Error 400 (bad request) to add / edit invalid product image for administrator/moderator;
-	When adding a new product, you need to define 3 images;
-	When editing the product must be identified 3 images or none;
-	Before creating a new product, you must first create a super category, category, subcategory, and specifications. Then create a new product;
-	After adding a product to a specific subcategory, you cannot add new specifications to it;
-	You can create a product for a subcategory with no specifications;
-	The best-selling products is a products that have an order status of 3 (completed), multiplied by the number of goods ordered;
-	Cannot add promotions to invisible item.

## Used tools and technologies
- Visual Studio Code with extensions: PHP IntelliSense, PHP IntelliSense – Crane, PHP Debug, PHP Namespace Resolver, PHP Getters & Setters, HTML CSS Support, EJS language support.
-	MariaDB 10.1.31;
-	Back-end by PHP 7.2.3;
-	Front-end by HTML, CSS, JS;
-	Libraries: JQuery, Bootstrap, Font Awesome;
-	Others: FlexSlider, ImageZoom, Infinity Scroll W3 Slider, Google Fonts, Composer, XAMPP, PHP Mailer, htaccess.

## Design patterns 
-	Front and Back-end parts;
- Model View Controller (MVC);
-	Data Access Objects (DAO);
-	PDO, OOP;
-	Namespaces;
-	Singletons;
-	Autoloaders.

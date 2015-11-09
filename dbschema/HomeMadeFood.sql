/*
 Navicat Premium Data Transfer

 Source Server         : My Machine
 Source Server Type    : MySQL
 Source Server Version : 50624
 Source Host           : localhost
 Source Database       : HomeMadeFood

 Target Server Type    : MySQL
 Target Server Version : 50624
 File Encoding         : utf-8

 Date: 07/22/2015 07:39:19 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `address`
-- ----------------------------
DROP TABLE IF EXISTS `address`;
CREATE TABLE `address` (
  `address_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `street_address` varchar(1024) CHARACTER SET latin1 DEFAULT NULL,
  `landmark` varchar(512) CHARACTER SET latin1 DEFAULT NULL,
  `city` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `state` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `country` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `pincode` varchar(21) CHARACTER SET latin1 DEFAULT NULL,
  `phone_number` varchar(21) CHARACTER SET latin1 DEFAULT NULL,
  `country_code` varchar(5) CHARACTER SET latin1 DEFAULT NULL,
  `is_default` tinyint(4) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `log_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `address`
-- ----------------------------
BEGIN;
INSERT INTO `address` VALUES ('1', 'Alan', 'feel so GH', 'Hyderabad', 'Andhra Pradesh', 'country', '500033', '9703570333', '+91', '0', '1', '2015-07-05 07:42:55'), ('2', 'sagar', 'near lnt', 'Mumbai', 'Maharashtra', 'country', '400710', '9930263002', '+91', '1', '3', '2015-07-06 09:06:55'), ('3', 'Finn', 'Fuji', 'Cook', 'Maharashtra', 'country', '255675', '5856883568', '+91', '0', '3', '2015-07-06 15:09:41');
COMMIT;

-- ----------------------------
--  Table structure for `bill`
-- ----------------------------
DROP TABLE IF EXISTS `bill`;
CREATE TABLE `bill` (
  `bill_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bill_code` varchar(255) DEFAULT NULL,
  `bill_amount` int(11) DEFAULT NULL,
  `bill_discount` int(11) DEFAULT NULL,
  `bill_total_amount` int(11) DEFAULT NULL,
  `bill_item_count` smallint(6) DEFAULT NULL,
  `bill_pay_through` varchar(255) DEFAULT NULL,
  `bill_date` date DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_phone_number` varchar(25) DEFAULT NULL,
  `use_delivery_address` varchar(1024) DEFAULT NULL,
  `basket_code` varchar(255) DEFAULT NULL,
  `item_quantity_bill_json` varchar(2048) DEFAULT NULL,
  `is_bill_payed` smallint(6) DEFAULT NULL,
  `log_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`bill_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `category`
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `category_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `category`
-- ----------------------------
BEGIN;
INSERT INTO `category` VALUES ('1', 'Veg'), ('2', 'Non-Veg');
COMMIT;

-- ----------------------------
--  Table structure for `chef`
-- ----------------------------
DROP TABLE IF EXISTS `chef`;
CREATE TABLE `chef` (
  `chef_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `f_name` varchar(255) DEFAULT NULL,
  `l_name` varchar(255) DEFAULT NULL,
  `country_code` varchar(5) DEFAULT NULL,
  `phone_number` varchar(21) DEFAULT NULL,
  `image_url` varchar(1024) DEFAULT NULL,
  `rating` smallint(5) unsigned DEFAULT NULL,
  `log_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`chef_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `chef`
-- ----------------------------
BEGIN;
INSERT INTO `chef` VALUES ('1', 'Admin', 'Chef', '+91', '9703570333', 'http://icons.iconarchive.com/icons/iconshock/cook/256/cheff-icon.png', '5', '2015-07-03 10:49:25');
COMMIT;

-- ----------------------------
--  Table structure for `chef_request`
-- ----------------------------
DROP TABLE IF EXISTS `chef_request`;
CREATE TABLE `chef_request` (
  `chef_request_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chef_request_fname` varchar(512) DEFAULT NULL,
  `chef_request_lname` varchar(512) DEFAULT NULL,
  `chef_request_description` varchar(2048) DEFAULT NULL,
  `chef_request_phone_number` varchar(20) DEFAULT NULL,
  `chef_request_address` varchar(1024) DEFAULT NULL,
  `chef_request_status` tinyint(4) DEFAULT NULL,
  `log_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`chef_request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `currency`
-- ----------------------------
DROP TABLE IF EXISTS `currency`;
CREATE TABLE `currency` (
  `currency_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(255) DEFAULT NULL,
  `currency_symbol` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`currency_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `currency`
-- ----------------------------
BEGIN;
INSERT INTO `currency` VALUES ('1', 'Rupee', '₹');
COMMIT;

-- ----------------------------
--  Table structure for `food_item`
-- ----------------------------
DROP TABLE IF EXISTS `food_item`;
CREATE TABLE `food_item` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(512) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(2048) CHARACTER SET latin1 DEFAULT NULL,
  `ingredients` varchar(1024) CHARACTER SET latin1 DEFAULT NULL,
  `preparation_method` varchar(2048) CHARACTER SET latin1 DEFAULT NULL,
  `nutrition` varchar(512) DEFAULT NULL,
  `food_image_1` varchar(1024) DEFAULT NULL,
  `food_image_2` varchar(1024) DEFAULT NULL,
  `food_image_3` varchar(1024) DEFAULT NULL,
  `food_image_4` varchar(1024) DEFAULT NULL,
  `food_image_5` varchar(1024) DEFAULT NULL,
  `food_image_6` varchar(1024) DEFAULT NULL,
  `rating` float(6,0) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `currency_id` smallint(5) unsigned DEFAULT '1',
  `chef_id` int(10) unsigned DEFAULT NULL,
  `category_id` smallint(5) unsigned DEFAULT NULL,
  `log_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `food_item`
-- ----------------------------
BEGIN;
INSERT INTO `food_item` VALUES ('1', 'Chicken biriyani', 'Our Chicken biriyani recipe is a great simple meal for winter weeknights.\n', '1 tablespoon vegetable oil\n 500g chicken thigh fillets, trimmed, quartered\n 1 medium brown onion, halved, thinly sliced\n 1 garlic clove, crushed\n 2cm piece ginger, peeled, finely grated\n 1/3 cup balti curry paste\n 1 1/2 cups SunRice Basmati Rice\n 1 cinnamon stick\n 2 cups Gravox Real chicken stock\n 1 cup thick plain yoghurt\n 1 Lebanese cucumber, deseeded, grated\n 1/2 teaspoon ground cumin\n Toasted flaked almonds and fresh coriander leaves, to serve', 'Heat oil in a heavy-based saucepan over medium-high heat. Cook chicken, turning, for 5 minutes or until browned. Transfer to a plate. Cook onion, garlic and ginger for 2 to 3 minutes or until onion has softened. Add curry paste. Cook for 1 minute or until fragrant. Add rice. Stir to coat.\nAdd cinnamon, stock and 1 cup cold water. Bring to the boil. Return chicken to pan. Reduce heat to low. Cover. Cook for 20 minutes or until rice is tender and chicken cooked through. Remove cinnamon. Discard.\nCombine yoghurt, cucumber and cumin in a bowl. Sprinkle biriyani with almonds and coriander. Serve with yoghurt mixture.\n', '2768kJ', 'http://www.taste.com.au/images/recipes/sfi/2009/07/23417_l.jpg', null, null, null, null, null, '478', '220', '1', '1', '2', '2015-07-09 12:00:25'), ('2', 'Lamb biriyani', 'A delicious one-pot wonder, biryani can be served on its own or as part of a banquet\n', '600g diced lean lamb\n 1/2 cup balti curry paste\n 2 tablespoons vegetable oil\n 2 medium brown onions, thinly sliced\n 1 1/2 cups doongara rice\n 400g can diced tomatoes\n 100g baby spinach\n 1/3 cup flaked almonds, toasted\n 1 long red chilli, thinly sliced\n 1/3 cup fresh coriander leaves\n plain yoghurt, to serve', 'Combine lamb and curry paste in a bowl. Toss lamb to coat. Set aside. Heat half the oil in a saucepan over medium-high heat. Cook onions, stirring, for 5 minutes or until browned. Remove to a plate.\nAdd remaining oil to pan. Cook lamb mixture, stirring occasionally, for 5 minutes or until browned. Return half the onions to pan. Add rice, tomatoes and 1 1/2 cups hot water. Bring to the boil. Reduce heat to low. Cover and simmer, stirring occasionally, for 20 to 25 minutes or until rice is tender and liquid absorbed.\nStir in spinach and half the almonds. Cook for 2 minutes or until spinach is just wilted. Top biriyani with remaining onion, almonds, chilli and coriander. Serve with yoghurt.\n', '3094kJ', 'http://www.taste.com.au/images/recipes/sfi/2007/12/18527_l.jpg', 'http://www.eknazar.com/Topics/Recipes/uploaded/RI2199_1imutton-biryani-recipe.jpg', 'http://www.flybirdex.com/data/frontImages/gallery/product_image/Mutton-Biryani.jpg', null, null, null, '5', '225', '1', '1', '2', '2015-07-09 12:03:43'), ('3', 'Chicken confit with sauce vierge\n\n', 'In this classic confit, the chicken is salted and seasoned with herbs, then slowly cooked in olive oil to make it rich and tender.\n', '10 thyme sprigs, leaves picked\n 12 whole black peppercorns\n 6 dried juniper berries (see notes), lightly crushed\n 2 bay leaves, crushed\n 5 garlic cloves, finely chopped\n 4 chicken marylands\n 1L (4 cups) olive oil\n Steamed green beans and pommes puree (see related recipe), to serve', 'Using a mortar and pestle, crush 2 tsp sea salt with the thyme, peppercorns and juniper berries. Press bay leaves and garlic into the fleshy side of the chicken and rub the skin with thyme salt. Cover and chill overnight to infuse.\nThe next day, preheat oven to 140C.\nRinse chicken under cold water and pat dry with paper towel. Place in a small roasting pan and cover with oil. Place pan over low heat until small bubbles appear on the surface (don’t let it boil), then transfer to the oven. Roast for 2 hours or until chicken is cooked through and is no longer pink. Set aside to cool. (The chicken will keep in the fridge for 1 week.)\nWhen ready to serve, preheat oven to 200C. Remove chicken from oil and place in a roasting pan. Bake for 15-20 minutes until the chicken is crisp and golden.\n', '450kj', 'http://www.taste.com.au/images/recipes/del/2014/03/36390_l.jpg', null, null, null, null, null, '4', '320', '1', '1', '2', '2015-07-09 12:05:48'), ('4', 'Spicy chicken burgers\n\n', 'Experience this crowd-pleasing main that will entertain your family and friends all summer long.\n', '1 long red chilli, seeds removed, chopped\n 1 garlic clove, chopped\n 5cm piece ginger, grated\n 2 x 200g chicken breast fillets, chopped\n 1 egg yolk\n 2 teaspoons curry powder\n 1 green apple, cored, quartered\n Juice of 1/2 lemon\n 2-3 tablespoons sunflower oil\n 4 hamburger buns, split, toasted\n Whole-egg mayonnaise, mango chutney, micro herbs or coriander sprigs, and French fries (optional) to serve', 'Place chilli, garlic and ginger in a food processor and pulse to combine. Add the chicken, egg yolk, curry powder and some salt and pepper, then pulse until it forms a coarse mixture. Form into 4 patties. Chill for 30 minutes.\nMeanwhile, slice the apple very thinly (a mandoline is ideal) and toss with the lemon juice in a bowl. Set aside.\nPreheat a chargrill or barbecue to medium-high. Brush the burger patties with oil, then grill, turning once, for 5-6 minutes or until cooked through.\n', '2128kj', 'http://www.taste.com.au/images/recipes/del/2010/12/26248_l.jpg', 'http://www.chicken.ie/_fileUpload/Image/Chicken_Burger.jpg', null, null, null, null, '5', '180', '1', '1', '2', '2015-07-09 12:08:58'), ('5', 'Lamb kebabs with kisir\n\n', 'Mediterranean-inspired lamb kebabs signals easy summer entertaining and a long, laidback afresco lunch.\n', '1 1/2 teaspoons fennel seeds, ground\n 1 1/2 teaspoons sweet paprika\n 3/4 teaspoon each turmeric, garam masala, ground coriander, ground cardamom and ground cinnamon\n 1 tablespoon grated fresh ginger\n 2 garlic cloves, chopped\n Juice of 1 lemon\n 1/4 cup (60ml) olive oil\n 1/2 bunch coriander, roughly chopped\n 4 lamb backstraps, cut into 2cm pieces\n 1 cup (280g) thick Greek-style yoghurt\n 2 tablespoons harissa (see note)\n Flatbread (recipe follows) and micro coriander, to serve (see note)', 'Place dry spices, ginger, garlic, lemon juice, oil and half the coriander in a small food processor and whiz until a paste. Season, then coat lamb in marinade. Cover and refrigerate for 4 hours or overnight.\nFor the kisir, place the burghul in a bowl and add enough cold water to cover, then stand for 30 minutes at room temperature until water is absorbed. Place onion in a bowl with lemon juice and soak for 30 minutes. Drain the burghul in a fine sieve pressing down to extract excess water. Place in a serving bowl with onion mixture and remaining ingredients, then season and stir to combine. Set aside.\nSoak 8 wooden skewers in cold water. Preheat a chargrill pan or barbecue to medium-high heat. Bring lamb to room temperature.\nThread the lamb onto skewers (or use clean twigs) and cook, turning, for 4-5 minutes for medium-rare or until cooked to your liking. Rest, loosely covered with foil, for 5 minutes.\n', '2122kj', 'http://www.taste.com.au/images/recipes/del/2012/01/28610_l.jpg', null, null, null, null, null, '3', '275', '1', '1', '2', '2015-07-09 12:11:00'), ('6', 'Portuguese-style chicken with warm corn salad\n\n', 'Spicy, fragrant, sweet and utterly scrumptious, roast chicken doesn\'t get much better than this.\n', '1.6kg chicken, rinsed, patted dry\n 3 lemons\n 1/3 cup oregano leaves, chopped\n 2 teaspoons dried ground oregano\n 4 red bird\'s-eye chillies, seeded, finely chopped\n 1 tablespoon brown sugar\n 4 cloves garlic, finely chopped\n 2 teaspoons lemon thyme leaves (see note)\n 1 1/2 tablespoons sweet paprika\n 2 tablespoons olive oil, plus extra, to brush\n 4 cobs corn, husks and silks removed\n 250g cherry truss tomatoes\n 1 cup coriander sprigs', 'Place chicken, breast-side down, on work surface. Using poultry shears or a cleaver, cut down either side of backbone, then remove and discard.\nTurn chicken breast-side up. Using the palm of your hand, push down breast to flatten. Tuck wings under breast bone. Push a metal skewer diagonally through wing to thigh on opposite side. Repeat with remaining skewer on other side to create a cross.\nPlace chicken in a large baking dish. Zest and juice 1 lemon in a small bowl. Add oregano, chillies, sugar, garlic, lemon thyme, 1 tablespoon paprika and 11?2 tablespoons oil. Stir to combine. Season well with salt and freshly ground black pepper. Pour lemon mixture over chicken and turn to coat. Cover with plastic wrap and refrigerate for 1 hour to marinate.\nPreheat barbecue to high. Cook chicken on grill for 5 minutes each side or until golden. Transfer to one side of barbecue plate, close lid and cook over indirect heat for 30 minutes or until juices run clear when the thickest part of thigh is pierced. Transfer to a plate, cover with foil and rest for 10 minutes.\n', '2576kJ', 'http://www.taste.com.au/images/recipes/mc/2012/11/31043_l.jpg', 'http://www.seriouseats.com/images/2012/08/20120805-food-lab-grilled-chicken-09.jpg', null, null, null, null, '4', '360', '1', '1', '2', '2015-07-09 15:01:56'), ('7', 'Banh xeo (crispy pancakes)\n\n', 'Take inspiration from Vietnamese cooking for this fresh and fragrant Asian pork pancake dish.\n', '220g (1 1/4 cups) rice flour\n 2 tablespoons cornflour\n 1 x 400ml can coconut milk\n 310ml (1 1/4 cups) iced water\n 1 teaspoon ground turmeric\n 1 teaspoon sugar\n 1/2 teaspoon salt\n Pinch of white pepper\n 2 tablespoons peanut oil\n 1 brown onion, halved, cut into thin wedges\n 300g Pork porterhouse Steak, thinly sliced\n 12 cooked prawns, peeled, coarsely chopped\n 130g (2 cups) bean sprouts, trimmed\n Butter lettuce leaves, to serve\n Fresh mint leaves, to serve', 'To make the nuoc cham, combine fish sauce, lime juice, water, sugar, chilli and garlic in a small bowl. Stir until sugar dissolves.\nStir the combined flour, coconut milk, water, turmeric, sugar and salt in a medium bowl. Season with white pepper. Cover and place in the fridge for 1 hour or overnight to rest.\nHeat a 20cm (base measurement) non-stick frying pan over high heat. Add 1 tablespoon of oil and heat until just smoking. Stir-fry the onion and pork for 5 minutes or until golden. Transfer to a plate. Wipe the pan clean.\n', '1370kJ', 'http://www.taste.com.au/images/recipes/agt/2009/11/23670_l.jpg', null, null, null, null, null, '3', '225', '1', '1', '1', '2015-07-09 15:04:57'), ('8', 'Asian soft noodle cabbage salad\n\n', 'Who doesn\'t love the classic noodle salad? Try our updated recipe that uses hokkien noodles for a twist of the unexpected.\n', '1/2 x 440g packet thin hokkien noodles\n 1/4 small (350g) red cabbage, thickly shredded\n 1/2 cup bean sprouts, trimmed\n 1 small red capsicum, thinly sliced\n 50g snow peas, trimmed, thinly sliced\n 1/2 cup fresh coriander leaves\n 2 green onions, thinly sliced diagonally', 'Place noodles in a heatproof bowl. Cover with boiling water. Stand for 2 minutes. Separate noodles with a fork. Drain. Refresh under cold water. Drain well.\nPlace cabbage, bean sprouts, capsicum, snow peas, coriander and green onion in a large bowl.\nMake Lime and soy dressing: Place lime juice, soy sauce, sesame oil, rice bran oil, caster sugar and garlic in a small bowl. Whisk until sugar has dissolved.\nAdd noodles and dressing to cabbage mixture (see note). Season with pepper. Toss well to combine. Serve.\n', '676kJ', 'http://www.taste.com.au/images/recipes/sfi/2014/10/39529_l.jpg', 'http://4.bp.blogspot.com/-LumLcUIX1Yk/Uq8COXOoqqI/AAAAAAAAOSc/ZwLyuGGjvo4/s1600/wet+noodles.jpg', 'http://site.cknoodle.com/Clients/cknoodle/dscf0116.jpg', 'http://site.cknoodle.com/Clients/cknoodle/dscf0061.jpg', null, null, '4', '180', '1', '1', '1', '2015-07-09 15:07:49'), ('9', 'Asian greens and shiitake mushrooms\n\n', 'Discover the taste of Asia with this authentic stir fry side dish starring fresh greens and shiitake mushrooms.\n', '2 tablespoons peanut oil\n 2 garlic cloves, crushed\n 2 teaspoons finely grated fresh ginger\n 100g fresh shiitake mushrooms, thinly sliced\n 1 bunch baby pak choy, trimmed, leaves separated, stems cut from leaves\n 1 bunch baby bok choy, trimmed\n 1 x 425g can baby corn spears, drained\n 2 tablespoons oyster sauce\n 1 tablespoon soy sauce\n 2 tablespoons water', 'Heat oil in a large frying pan or wok over medium-high heat. Add garlic and ginger. Stir-fry for 30 seconds or until aromatic.\nAdd the mushroom and stir-fry for 2 minutes. Add the pak choy stems and stir-fry for 1 minute. Add the pak choy leaves, buk choy, corn, oyster sauce and soy sauce. Toss to combine.\nAdd the water and reduce heat to low. Cover and cook for 2 minutes or until the vegetables are just tender. Serve.\n', '420kJ', 'http://www.taste.com.au/images/recipes/agt/2009/01/21475_l.jpg', null, null, null, null, null, '2', '180', '1', '1', '2', '2015-07-09 15:08:57'), ('10', 'Banana coconut tapioca puddings (che chuoi)\n\n', 'Tropical banana, mango and pineapple are the star ingredients in this exotic Asian boba pudding.\n', '1 cup (200g) tapioca pearls\n 400g can coconut milk\n 1 cup (250ml) water\n 1/2 cup (80g) finely chopped palm sugar\n 2 pandan leaves, tied into a knot\n 3 just ripe bananas, peeled, thickly sliced\n 2 tablespoons finely grated dark palm sugar (see note)\n 1 tablespoon water, extra\n 1 tablespoon sesame seeds\n 1 mango, peeled, thinly sliced, to serve\n 1/2 ripe pineapple, peeled, thinly sliced, to serve', 'Place the tapioca in a large bowl and cover with cold water. Set aside for 2 hours to soak. Strain through a fine sieve. Cook in a large saucepan of boiling water for 10 minutes or until opaque. Drain well.\nMeanwhile, combine the coconut milk, water, sugar and pandan leaves in a large saucepan over low heat. Cook, stirring, for 5 minutes or until sugar dissolves and mixture is heated through. Add the tapioca and gently stir to combine. Remove from heat and set aside to cool slightly. Add the banana and transfer to a bowl and cover with plastic wrap. Place in the fridge to chill.\nCombine the dark palm sugar and water in a small frying pan over high heat. Cook, stirring, for 2 minutes or until sugar dissolves. Add the sesame seeds and cook, stirring, for 2 minutes or until syrup thickens.\nRemove and discard the pandan leaves from tapioca. Spoon the tapioca among serving bowls. Serve topped with mango and pineapple slices and drizzle with sesame syrup.\n', '1581kJ', 'http://www.taste.com.au/images/recipes/nb/2008/02/19022_l.jpg', null, null, null, null, null, '3', '120', '1', '1', '1', '2015-07-09 15:10:47'), ('11', 'Chilli jam scallops with asian greens\n\n', 'Beautiful Asian greens taste fantastic with these fabulous spicy scallops.\n', '2 bunches Chinese broccoli (gai lan), trimmed, cut into 6cm lengths\n 20 scallops without roe\n 1 1/2 tablespoons chilli jam*\n 2 teaspoons olive oil\n 1 small onion, thinly sliced\n 2 teaspoons light soy sauce', 'Steam the Chinese broccoli, covered, over a large saucepan of boiling water for 2-3 minutes until just tender. Drain and set aside.\nMeanwhile, toss the scallops with 1 tablespoon of the chilli jam. Heat a frypan over medium-high heat and add 1 teaspoon of the olive oil. When hot, add the scallops and pan-fry for 1 minute on each side until just cooked. Remove from the frypan and cover to keep warm.\nAdd remaining teaspoon of oil to pan and reduce heat to medium. Add onion and cook for 3-4 minutes until softened. Add remaining 1/2 tablespoon chilli jam and broccoli, tossing to coat. Remove from heat and stir in soy.\nServe vegetables in bowls with scallops.\n', '598kJ	', 'http://www.taste.com.au/images/recipes/del/2005/09/4251_l.jpg', null, null, null, null, null, '2', '150', '1', '1', '1', '2015-07-09 15:12:29'), ('12', 'Chinese fried rice\n\n', 'This fragrant fried rice incorporates lup chong for authentic Chinese flavour.\n', '1 1/2 cups SunRice White Long Grain Rice\n 3 eggs\n 2 teaspoons sesame oil\n 3 teaspoons peanut oil\n 5 (30g each) dried Chinese pork sausages, thinly sliced (see note)\n 3 green onions, thinly sliced\n 2 garlic cloves, crushed\n 1 long red chilli, finely chopped\n 2 tablespoons salt-reduced soy sauce\n 1 tablespoon oyster sauce\n 1/2 cup frozen peas, thawed\n 1 long red chilli, deseeded, thinly sliced lengthways, to serve', 'Cook rice following absorption method on packet until tender. Line a baking tray with baking paper. Spread rice over prepared tray. Cool to room temperature. Cover and refrigerate for 3 hours.\nCombine eggs and half the sesame oil in a jug. Heat a wok over high heat. Add 1 teaspoon peanut oil. Swirl to coat. Add one-third of the egg mixture. Swirl to coat. Cook for 1 minute or until just set. Remove to a board. Roll up. Thinly slice. Repeat twice with remaining peanut oil and egg mixture.\nAdd sausage and onion to wok. Stir-fry for 2 to 3 minutes or until sausage has browned. Add garlic and chilli. Stir-fry for 1 minute or until fragrant. Add rice, soy sauce, oyster sauce, peas and remaining sesame oil. Stir-fry for 2 minutes or until heated through. Top with chilli. Serve.\n', '2147kJ', 'http://www.taste.com.au/images/recipes/sfi/2008/10/20745_l.jpg', null, null, null, null, null, '3', '180', '1', '1', '1', '2015-07-09 15:14:18'), ('13', 'Coconut, lime and chilli barbecued prawns\n\n', 'Shell out less at the prawn broker for this handy, versatile meal solution.\n', '1 lime\n 1/3 cup coconut milk\n 1/3 cup finely chopped fresh coriander stems\n 3 garlic cloves, crushed\n 1 long red chilli, finely chopped\n 1 tablespoon Ayam fish sauce\n 1 tablespoon soy sauce\n 750g green king prawns, peeled, tails intact, deveined\n 1 tablespoon lime juice\n Lime wedges, fresh coriander leaves and steamed SunRice White Long Grain Rice, to serve', 'Using a vegetable peeler, cut long strips of rind from lime. Combine coconut milk, coriander, garlic, chilli, fish sauce, soy sauce and lime rind in a shallow dish. Reserve 2 tablespoons mixture. Add prawns to remaining mixture. Toss to coat. Cover with plastic wrap. Refrigerate for 3 to 4 hours, if time permits.\nPreheat a barbecue plate or chargrill on medium-high heat. Add lime juice to prawn mixture. Toss to coat. Remove and discard lime rind from prawn mixture and reserved coconut milk mixture. Thread prawns onto skewers. Cook, brushing with reserved coconut milk mixture, for 2 to 3 minutes each side or until pink and lightly charred.\nServe skewers with lime wedges, coriander and rice.\n', '1663kJ', 'http://www.taste.com.au/images/recipes/sfi/2010/12/26091_l.jpg', null, null, null, null, null, '3', '250', '1', '1', '2', '2015-07-09 15:17:22'), ('14', 'Chicken nuggets\n\n', 'Why not let the kids create their own healthy version of chicken nuggets.\n', '1 egg, lightly whisked\n 1/2 cup (45g) cornflake crumbs\n 1 (about 200g) chicken breast fillet, cut into 3cm pieces\n 1 small (about 290g) orange sweet potato (kumara), peeled, cut into 1cm-thick slices\n Olive oil spray\n Sweet chilli sauce, to serve\n Mixed salad leaves, to serve', 'Preheat oven to 200C. Line 2 oven trays with baking paper.\nPlace the egg and cornflake crumbs in separate bowls. Dip a piece of chicken into the egg then in the cornflake crumbs, tossing to coat. Place on 1 prepared tray.\nUse a 4cm-diameter star pastry cutter to cut stars from the sweet potato slices. Place on the remaining tray.\nLightly spray the chicken and sweet potato with olive oil spray. Bake the sweet potato for 10 minutes. Add the chicken and bake for a further 10-15 minutes or until the nuggets are cooked through and the sweet potato is tender. Serve with sweet chilli sauce and salad leaves.\n', '1370kJ', 'http://www.taste.com.au/images/recipes/tas/2012/01/27997_l.jpg', null, null, null, null, null, '3', '195', '1', '1', '2', '2015-07-09 15:19:42'), ('15', 'Fritter faces\n\n', 'Need a little lunchbox snack that really hits the spot? Try these fritters for a delicious snack.\n', ' 4 medium zucchini, grated\n 2/3 cup self-raising flour\n 2 eggs, lightly beaten\n 1 1/2 tablespoons roughly chopped fresh basil leaves\n 250g reduced-fat fresh ricotta cheese, crumbled\n 2 tablespoons Azalea grapeseed oil\n 1 small carrot, peeled, grated\n 1 tablespoon frozen corn kernels\n 1 small red capsicum, halved lengthways, sliced', 'Squeeze excess liquid from zucchini. Combine zucchini, flour, egg and basil in a bowl. Add ricotta. Mix until just combined (mixture will appear quite lumpy).\nHeat oil in a non-stick frying pan over medium heat. Spoon 1/4 cup batter into pan, spreading slightly with a spatula. Repeat to make 3 rounds. Press carrot into batter to resemble hair, corn for eyes and capsicum for a smile. Cook for 2 to 3 minutes until browned underneath and top just set. Turn. Cook for 1 to 2 minutes or until fritters are cooked through. Transfer to a plate lined with paper towel. Cool. Repeat with remaining batter, carrot, corn and capsicum. Serve.\n', '474kJ', 'http://www.taste.com.au/images/recipes/sfi/2010/11/25907_l.jpg', null, null, null, null, null, '5', '275', '1', '1', '1', '2015-07-09 15:22:30'), ('16', 'Spicy-sweet nuts\n\n', 'Throwing a Christmas party at home? Send your guests off with a delicious take-home food gift like Curtis Stone\'s spicy-sweet nuts.\n', '1 1/2 cups raw cashews\n 1 1/2 cups raw pecans\n 1 cup raw whole almonds\n 2 tablespoons plus 2 teaspoons raw sugar\n 2 teaspoons fleur de sel\n 1/2 teaspoon cayenne pepper\n 1/8 teaspoon smoked paprika\n 1 tablespoon honey\n 1 tablespoon molasses\n 2 teaspoons coarsely chopped fresh rosemary leaves\n 1/2 teaspoon grated orange peel', 'Preheat the oven to 175°C (150°C).\nArrange the cashews, pecans, and almonds in an even layer over a heavy large baking tray. Roast for 8 minutes, or just until the nuts are hot.\nMeanwhile, in a large bowl, mix 2 tablespoons of the raw sugar, 1 1/2 teaspoons of the fleur de sel, cayenne, and paprika to blend.\nTransfer the nuts to the sugar-spice mixture in the large bowl. Add the honey, molasses, rosemary, and orange, and stir to coat.\nLine the same baking tray with nonstick foil and return the nut mixture to the baking sheet, spreading them out in an even layer. Sprinkle the remaining 2 teaspoons raw sugar and 1/2 teaspoon fleur de sel over the nuts and roast for about 15 minutes, or until the nuts are toasted. Cool slightly, then separate the nuts, or keep them in small clusters, if desired.\nCool completely before serving. The coating on the nuts will harden as the nuts cool.\n', 'NA', 'http://www.taste.com.au/images/recipes/col/2013/11/34123_l.jpg', null, null, null, null, null, '4', '220', '1', '1', '1', '2015-07-09 15:25:26'), ('17', 'Winter fruit salad with sweet tofu cream\n\n', 'Winter fruit salad with sweet tofu cream\n\n', '300g firm tofu, drained\n 1 teaspoon grated lime zest\n 1/4 cup (60ml) lime juice\n 3 teaspoons honey\nWinter fruit salad\n 100g pitted prunes\n 100g whole dried figs\n 200g bag mixed dried whole fruit\n 1 vanilla bean, split, seeds scraped\n 1 cinnamon quill', 'For fruit, place all ingredients in a saucepan and cover with water. Bring to a simmer over medium-low heat and cook for 10 minutes until fruits are plump. Transfer fruit to a bowl with a slotted spoon. Simmer liquid over medium heat until reduced by half. Pour over fruit, cover and chill.\nWhiz tofu in a food processor until smooth and thick. Add zest, juice and honey and process to combine. Serve with winter fruit salad.\n', '100kJ', 'http://www.taste.com.au/images/recipes/del/2005/08/4250_l.jpg', null, null, null, null, null, '3', '120', '1', '1', '1', '2015-07-09 15:26:32');
COMMIT;

-- ----------------------------
--  Table structure for `item_serving_mapping`
-- ----------------------------
DROP TABLE IF EXISTS `item_serving_mapping`;
CREATE TABLE `item_serving_mapping` (
  `item_serving_mapping_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(10) unsigned NOT NULL,
  `serving_id` smallint(5) unsigned NOT NULL,
  `available_for` int(11) DEFAULT NULL,
  `order_count` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `log_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`item_serving_mapping_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `kitchen`
-- ----------------------------
DROP TABLE IF EXISTS `kitchen`;
CREATE TABLE `kitchen` (
  `kitchen_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(1024) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(10,8) DEFAULT NULL,
  `log_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`kitchen_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `likes`
-- ----------------------------
DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `food_item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `rating` float DEFAULT NULL,
  `review` varchar(1024) DEFAULT NULL,
  `review_detail` varchar(2048) DEFAULT NULL,
  `log_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`food_item_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `order`
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `basket_code` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_quantity_price_json` varchar(2048) DEFAULT NULL,
  `time_slot_id` smallint(6) NOT NULL,
  `status` smallint(6) DEFAULT '1',
  `date` date DEFAULT NULL,
  `flag_category` tinyint(4) NOT NULL,
  `address_id` int(11) DEFAULT NULL,
  `log_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `preffered_list`
-- ----------------------------
DROP TABLE IF EXISTS `preffered_list`;
CREATE TABLE `preffered_list` (
  `preferred_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `serving_id` smallint(6) NOT NULL,
  `user_id` int(11) NOT NULL,
  `log_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`preferred_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `push_reg`
-- ----------------------------
DROP TABLE IF EXISTS `push_reg`;
CREATE TABLE `push_reg` (
  `push_reg_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `push_reg_token` varchar(1024) DEFAULT NULL,
  `device_imei` varchar(1024) DEFAULT NULL,
  `os_id` int(11) DEFAULT NULL,
  `os_name` varchar(512) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`push_reg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `serving`
-- ----------------------------
DROP TABLE IF EXISTS `serving`;
CREATE TABLE `serving` (
  `serving_id` smallint(6) NOT NULL,
  `serving_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`serving_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `serving`
-- ----------------------------
BEGIN;
INSERT INTO `serving` VALUES ('1', 'Lunch'), ('2', 'Dinner'), ('3', 'Backed'), ('4', 'Sweets'), ('5', 'Others');
COMMIT;

-- ----------------------------
--  Table structure for `status`
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `status_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `status`
-- ----------------------------
BEGIN;
INSERT INTO `status` VALUES ('1', 'Order Placed'), ('2', 'Payment Accepted'), ('3', 'Preparation in Progress'), ('4', 'Package Ready'), ('5', 'Shipped'), ('6', 'In Transit'), ('7', 'Delivered'), ('8', 'Cancelled');
COMMIT;

-- ----------------------------
--  Table structure for `time_slot`
-- ----------------------------
DROP TABLE IF EXISTS `time_slot`;
CREATE TABLE `time_slot` (
  `time_slot_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `time_slot_name` varchar(255) DEFAULT NULL,
  `time_slot_start` time DEFAULT NULL,
  `time_slot_end` time DEFAULT NULL,
  PRIMARY KEY (`time_slot_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `time_slot`
-- ----------------------------
BEGIN;
INSERT INTO `time_slot` VALUES ('1', 'Lunch (12 PM to 3 PM)', '12:00:01', '15:00:00'), ('2', 'Dinner (7 PM to 9 PM)', '19:00:01', '21:00:00'), ('3', 'Snaks (5 PM to 6 PM)', '17:00:01', '18:00:00');
COMMIT;

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `f_name` varchar(255) DEFAULT NULL,
  `l_name` varchar(255) DEFAULT NULL,
  `country_code` varchar(5) DEFAULT NULL,
  `phone_number` varchar(21) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `image_url` varchar(1024) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `log_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `user`
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES ('1', 'Raviraja', 'KV', '+91', '9703570333', '', '', '1970-01-01', '2015-07-03 12:08:16'), ('2', 'Mohan', 'Krishna', '+91', '9866211677', '', '', '1970-01-01', '2015-07-05 16:45:40'), ('3', 'Sagar', 'Kondaveti', '+91', '9930263002', '', '', '1970-01-01', '2015-07-06 07:02:40'), ('4', 'Karan', 'Ch', '+91', '9892122491', '', '', '1970-01-01', '2015-07-06 08:42:41'), ('5', 'Ravi ', 'Hedau ', '+91', '9967970726', '', '', '1970-01-01', '2015-07-06 16:58:22');
COMMIT;

-- ----------------------------
--  Table structure for `user_item_rating`
-- ----------------------------
DROP TABLE IF EXISTS `user_item_rating`;
CREATE TABLE `user_item_rating` (
  `user_id` int(10) unsigned NOT NULL,
  `item_d` int(10) unsigned NOT NULL,
  `ratting` float(6,0) DEFAULT NULL,
  `log_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`,`item_d`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;

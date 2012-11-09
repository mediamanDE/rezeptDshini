CREATE TABLE "Book" (
  "id" int(10) unsigned NOT NULL AUTO_INCREMENT,
  "isbn" varchar(22) NOT NULL,
  "title" varchar(255) NOT NULL,
  "release_date" date NOT NULL,
  PRIMARY KEY ("id"),
  UNIQUE KEY "isbn" ("isbn")
) AUTO_INCREMENT=4 ;

INSERT INTO `Book` VALUES(1, 'ISBN 978-0307269997', 'The Girl Who Kicked the Hornet''s Nest', '2010-05-25');
INSERT INTO `Book` VALUES(2, 'ISBN 978-0441018642', 'Dead in the Family (Sookie Stackhouse, Book 10)', '2010-05-04');
INSERT INTO `Book` VALUES(3, 'ISBN 978-0446562423', 'Innocent', '2010-05-04');

CREATE TABLE "Library" (
  "id" int(10) unsigned NOT NULL AUTO_INCREMENT,
  "name" varchar(40) NOT NULL,
  PRIMARY KEY ("id")
) AUTO_INCREMENT=5 ;

INSERT INTO `Library` VALUES(1, 'Home library');
INSERT INTO `Library` VALUES(2, 'Municipal library');

CREATE TABLE "LibraryBook" (
  "libraryID" int(10) unsigned NOT NULL,
  "bookISBN" varchar(22) NOT NULL,
  "location" varchar(80) NOT NULL,
  PRIMARY KEY ("libraryID","bookISBN"),
  KEY "bookISBN" ("bookISBN")
);

INSERT INTO `LibraryBook` VALUES(1, 'ISBN 978-0307269997', 'Shelf A');
INSERT INTO `LibraryBook` VALUES(1, 'ISBN 978-0446562423 ', 'Shelf C');
INSERT INTO `LibraryBook` VALUES(2, 'ISBN 978-0307269997', 'Shelf 12-23');
INSERT INTO `LibraryBook` VALUES(2, 'ISBN 978-0441018642', 'Shelf 12-38');

CREATE TABLE "LibraryComment" (
  "id" int(10) unsigned NOT NULL AUTO_INCREMENT,
  "libraryID" int(10) unsigned NOT NULL,
  "comment" text NOT NULL,
  PRIMARY KEY ("id"),
  KEY "libraryID" ("libraryID")
) AUTO_INCREMENT=

CREATE TABLE "LibraryService" (
  "libraryID" int(10) unsigned NOT NULL,
  "serviceID" int(10) unsigned NOT NULL,
  PRIMARY KEY ("libraryID","serviceID"),
  KEY "bookISBN" ("serviceID")
);

INSERT INTO `LibraryService` VALUES(1, 1);
INSERT INTO `LibraryService` VALUES(1, 2);
INSERT INTO `LibraryService` VALUES(2, 2);

CREATE TABLE "Service" (
  "id" int(10) unsigned NOT NULL AUTO_INCREMENT,
  "name" varchar(32) NOT NULL,
  PRIMARY KEY ("id"),
  UNIQUE KEY "name" ("name")
) AUTO_INCREMENT=4 ;

INSERT INTO `Service` VALUES(1, 'Audio books');
INSERT INTO `Service` VALUES(2, 'Internet');
INSERT INTO `Service` VALUES(3, 'Video games');


ALTER TABLE `LibraryBook`
  ADD CONSTRAINT "LibraryBook_ibfk_1" FOREIGN KEY ("libraryID") REFERENCES "Library" ("id") ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT "LibraryBook_ibfk_2" FOREIGN KEY ("bookISBN") REFERENCES "Book" ("isbn") ON DELETE CASCADE ON UPDATE CASCADE;
    

ALTER TABLE `LibraryComment`
  ADD CONSTRAINT "LibraryComment_ibfk_1" FOREIGN KEY ("libraryID") REFERENCES "Library" ("id") ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `LibraryService`
  ADD CONSTRAINT "LibraryService_ibfk_3" FOREIGN KEY ("libraryID") REFERENCES "Library" ("id") ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT "LibraryService_ibfk_4" FOREIGN KEY ("serviceID") REFERENCES "Service" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

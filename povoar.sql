INSERT INTO LOCATION (idLocation, city, country) VALUES (1, 'PORTO', 'PORTUGAL');
INSERT INTO LOCATION (idLocation, city, country) VALUES (2, 'SAO PAULO', 'BRAZIL');
INSERT INTO LOCATION (idLocation, city, country) VALUES (3, 'NEW YORK', 'U.S.A.');
INSERT INTO LOCATION (idLocation, city, country) VALUES (4, 'BARCELONA', 'SPAIN');
INSERT INTO LOCATION (idLocation, city, country) VALUES (5, 'PARIS', 'FRANCE');

INSERT INTO USER (idUser, name, password, email, gender, birthdate, cellphone, profilePicture, type) VALUES (1, 'Daniel', '1234', 'daniel@gmail.com', 'M', '2000-09-13', NULL, NULL, 'Owner');
INSERT INTO USER (idUser, name, password, email, gender, birthdate, cellphone, profilePicture, type) VALUES (2, 'Gustavo', '4321', 'gustavo@gmail.com', 'M', '2000-02-13', NULL, NULL, 'Tourist');

INSERT INTO MESSAGES (idMessages, idSend, idReceive, date, text) VALUES (1, 1, 2, '2019-09-13', 'Olá');

INSERT INTO PROPERTY (idProperty, idOwner, address, title, price, description, rate) VALUES (1, 1, 'Rua do Amial', 'Quarto', 75.00, 'Um quarto', 0);

INSERT INTO COMMENTS (idComments, idProperty, idUser, date, text) VALUES (1, 1, 2, '2019-09-13', 'Realmente é um quarto');

INSERT INTO PHOTO (idPhoto, idProperty, uploadDate, name, photo) VALUES (1, 1, '2018-09-13', 'O quarto', NULL);

INSERT INTO RENT (idRent, idUser, idProperty, moveIn, moveOut, payment, rate, price) VALUES (1, 2, 1, '2018-08-13', '2018-08-14', 'PayPal', 5, 150.00);

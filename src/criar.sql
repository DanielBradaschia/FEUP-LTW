DROP TABLE IF EXISTS USER;
CREATE TABLE USER(
    idUser INTEGER PRIMARY KEY,
    name TEXT NOT NULL,
    password TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    gender CHAR CHECK (gender == 'F' OR gender == 'f' OR gender == 'M' OR gender == 'm'),
    birthdate DATE,
    cellphone INTEGER,
    profilePicture BLOB,
    type TEXT CHECK (type == 'Owner' OR type == 'Tourist')
);

DROP TABLE IF EXISTS MESSAGES;
CREATE TABLE MESSAGES(
    idMessages INTEGER,
    idSend   INTEGER REFERENCES USER (idUser),
    idReceive   INTEGER REFERENCES USER (idUser),
    date DATE,
    text TEXT NOT NULL,
    PRIMARY KEY(idMessages, idSend, idReceive)
);

DROP TABLE IF EXISTS LOCATION;
CREATE TABLE IF NOT EXISTS LOCATION (
    idLocation INTEGER PRIMARY KEY,
    city       TEXT  NOT NULL,
    country    TEXT  NOT NULL
);

DROP TABLE IF EXISTS COMMENTS;
CREATE TABLE IF NOT EXISTS COMMENTS (
    idComments INTEGER PRIMARY KEY,
    idProperty   INTEGER REFERENCES PROPERTY (idProperty),
    idUser   INTEGER REFERENCES USER (idUser),
    date DATE,
    text TEXT
);

DROP TABLE IF EXISTS PHOTO;
CREATE TABLE IF NOT EXISTS PHOTO (
    idPhoto INTEGER PRIMARY KEY,
    idProperty   INTEGER REFERENCES PROPERTY (idProperty),
    uploadDate DATE,
    name TEXT,
    photo BLOB
);

DROP TABLE IF EXISTS RENT;
CREATE TABLE IF NOT EXISTS RENT (
    idRent INTEGER PRIMARY KEY,
    idUser INTEGER REFERENCES USER (idUser),
    idProperty INTEGER REFERENCES PROPERTY (idProperty),
    moveIn DATE,
    moveOut DATE,
    payment TEXT NOT NULL,
    price NUMERIC NOT NULL
);

DROP TABLE IF EXISTS PROPERTY;
CREATE TABLE IF NOT EXISTS PROPERTY (
    idProperty INTEGER PRIMARY KEY,
    idOwner INTEGER REFERENCES USER (idUser),
    address TEXT,
    title TEXT,
    price FLOAT,
    description TEXT,
    rate NUMERIC
);


DROP TABLE IF EXISTS REVIEWS;
CREATE TABLE IF NOT EXISTS REVIEWS(
    idReviews INTEGER PRIMARY KEY,
    idProperty INTEGER REFERENCES PROPERTY (idProperty),
    idUser INTEGER REFERENCES USER (idUser),
    title TEXT,
    userRate INTEGER,
    text TEXT,
    likes INTEGER,
    date DATE
);

DROP TABLE IF EXISTS REVIEWPHOTO;
CREATE TABLE IF NOT EXSITS REVIEWPHOTO(
    idReviewPhoto INTEGER PRIMARY KEY,
    name TEXT,
    idProperty INTEGER REFERENCES PROPERTY (idProperty),
    idReview INTEGER REFERENCES REVIEWS (idReviews)
);


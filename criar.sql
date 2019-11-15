DROP TABLE IF EXISTS USER;
CREATE TABLE USER(
    idUser INTEGER PRIMARY KEY,
    name TEXT NOT NULL,
    password TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    gender CHAR CHECK (gender == 'F' OR gender == 'f' OR gender == 'M' OR gender == 'm'),
    birthdate DATE,
    cellphone INTEGER,
    profilePicture BLOB
);

DROP TABLE IF EXISTS OWNER;
CREATE TABLE OWNER(
    idUser INTEGER REFERENCES USER (idUser),
    idOwner INTEGER PRIMARY KEY
);

DROP TABLE IF EXISTS MESSAGES;
CREATE TABLE MESSAGES(
    idMessages INTEGER,
    idSend   INTEGER REFERENCES USER (idUser),
    idReceive   INTEGER REFERENCES USER (idUser),
    date DATE,
    text TEXT,
    PRIMARY KEY(idMessages, idSend, idReceive)
);

DROP TABLE IF EXISTS LOCATION;
CREATE TABLE IF NOT EXISTS LOCATION (
    idLocation INTEGER PRIMARY KEY,
    city       TEXT  NOT NULL,
    country    TEXT  NOT NULL
);
/*
DROP TABLE IF EXISTS COMMENTS;
CREATE TABLE IF NOT EXISTS COMMENTS (
    idComments INTEGER PRIMARY KEY,
    date DATE,
    text TEXT
);
*/
DROP TABLE IF EXISTS RENT;
CREATE TABLE IF NOT EXISTS RENT (
    idRent INTEGER PRIMARY KEY,
    idUser   INTEGER REFERENCES USER (idUser),
    idProperty   INTEGER REFERENCES PROPERTY (idProperty),
    moveIn DATE,
    moveOut DATE,
    payment TEXT NOT NULL,
    rate NUMERIC,
    price NUMERIC NOT NULL
);


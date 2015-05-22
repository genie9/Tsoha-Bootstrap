CREATE TABLE Jasen (
    id SERIAL PRIMARY KEY,
    nimi varchar(50) NOT NULL,
    email varchar(50) NOT NULL,
    katuosoite varchar(50),
    posti varchar(50),
    puhelin integer,
    syntyma date NOT NULL,
    huoltaja varchar(50),
    laji varchar[],
    status boolean DEFAULT false,
    skilstatus boolean DEFAULT false,
    seura varchar(20)
);

CREATE TABLE Hallitus (
    id SERIAL PRIMARY KEY,
    vuosi integer NOT NULL
);

CREATE TABLE Hallitus_has_Jasen (
    hallitus_id integer NOT NULL,
    jasen_id integer NOT NULL,
    PRIMARY KEY (hallitus_id, jasen_id),
    FOREIGN KEY (hallitus_id) REFERENCES Hallitus
);

CREATE TABLE Kokous (
    id SERIAL PRIMARY KEY, 
    pvm date,
    aika varchar(5) NOT NULL,
    nimi varchar(50),
    tyyppi varchar(15) NOT NULL,
    muuta varchar(200)
);

CREATE TABLE Kokous_has_Jasen (
    kokous_id integer NOT NULL,
    jasen_id integer NOT NULL,
    PRIMARY KEY (kokous_id, jasen_id),
    FOREIGN KEY (kokous_id) REFERENCES Kokous
);

CREATE TABLE Dokumentti (
    id SERIAL PRIMARY KEY,
    nimi varchar(50) NOT NULL,
    pvm date NOT NULL,
    url varchar(1000) NOT NULL,
    kokous_id integer NOT NULL,
    FOREIGN KEY (kokous_id) REFERENCES Kokous
);

CREATE TABLE Jasenmaksu (
    id SERIAL PRIMARY KEY,
    vuosi date,
    maara_lapsi numeric,
    maara_aikuinen numeric,
    maara_skil numeric
);

CREATE TABLE Jasen_has_Jasenmaksu (
    jasen_id integer NOT NULL,
    jasenmaksu_id integer NOT NULL,
    PRIMARY KEY (jasen_id, jasenmaksu_id),
    FOREIGN KEY (jasen_id) REFERENCES Jasen,
    FOREIGN KEY (jasenmaksu_id) REFERENCES Jasenmaksu
);
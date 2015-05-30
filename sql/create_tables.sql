    CREATE TABLE Jasen (
    id SERIAL PRIMARY KEY,
    nimi varchar(50) NOT NULL,
    sala varchar(50) NOT NULL,
    email varchar(50) NOT NULL,
    katuosoite varchar(50),
    posti varchar(50),
    puhelin varchar(50),
    syntyma date NOT NULL,
    huoltaja varchar(50),
    laji text[],
    rek_aika timestamp,
    status varchar(10) DEFAULT 'Kesken',
    skilstatus boolean DEFAULT false,
    seura varchar(50)
);

CREATE TABLE Hallitus (
    /*id SERIAL PRIMARY KEY,*/
    vuosi integer PRIMARY KEY NOT NULL
);

CREATE TABLE Kokous (
    pvm date PRIMARY KEY NOT NULL,
    aika varchar(5) NOT NULL,
    paikka varchar(25),
    nimi varchar(50),
    tyyppi varchar(20) NOT NULL,
    muuta varchar(200),
    hal_vuosi integer, 
    FOREIGN KEY (hal_vuosi) REFERENCES Hallitus
);

CREATE TABLE Hallitus_has_Jasen (
    hal_vuosi integer NOT NULL,
    jasen_id integer NOT NULL,
    PRIMARY KEY (hal_vuosi, jasen_id),
    FOREIGN KEY (hal_vuosi) REFERENCES Hallitus
);

CREATE TABLE Kokous_has_Jasen (
    kokous_pvm date NOT NULL,
    jasen_id integer NOT NULL,
    PRIMARY KEY (kokous_pvm, jasen_id),
    FOREIGN KEY (kokous_pvm) REFERENCES Kokous
);

CREATE TABLE Dokumentti (
    id SERIAL PRIMARY KEY,
    nimi varchar(50) NOT NULL,
    pvm date NOT NULL,
    url text NOT NULL,
    kokous_pvm date NOT NULL,
    FOREIGN KEY (kokous_pvm) REFERENCES Kokous
);

CREATE TABLE Jasenmaksu (
    id SERIAL PRIMARY KEY,
    vuosi date NOT NULL,
    maara_lapsi numeric NOT NULL,
    maara_aikuinen numeric NOT NULL,
    maara_skil numeric NOT NULL
);

CREATE TABLE Jasen_has_Jasenmaksu (
    jasen_id integer NOT NULL,
    jasenmaksu_id integer NOT NULL,
    PRIMARY KEY (jasen_id, jasenmaksu_id),
    FOREIGN KEY (jasen_id) REFERENCES Jasen,
    FOREIGN KEY (jasenmaksu_id) REFERENCES Jasenmaksu
);
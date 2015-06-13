INSERT INTO Jasen (nimi, sala, email, syntyma, katuosoite, posti, puhelin, status) VALUES ('Kira Kallio', 'kira', 'kira.kallio@gmail.com', '11.11.2011', 'Kalliokolo 12', '98765, Half Dome', '5554242', true);
INSERT INTO Jasen (nimi, sala, email, syntyma, katuosoite, posti, puhelin, status) VALUES ('Himo Kiipeilijä', 'himo', 'himo.kiipeilija@gmail.com', '21.12.2012', 'Kallioluola', '12345 Yosemite', '5552323', true);
INSERT INTO Hallitus (vuosi) VALUES ('2015');
INSERT INTO Kokous (pvm, aika, paikka, tyyppi, hal_id) VALUES ('23.3.2015', '18:00', 'Cave', 'Perustamiskokous', '1'); 
INSERT INTO Kokous (pvm, aika, paikka, tyyppi, hal_id) VALUES ('23.4.2015', '18:00', 'Cave', 'Hallituksen kokous', '1'); 
INSERT INTO Kokous_has_Jasen (kokous_id, jasen_id) VALUES ('1', '2');
INSERT INTO Kokous_has_Jasen (kokous_id, jasen_id) VALUES ('1', '1');
INSERT INTO Kokous_has_Jasen (kokous_id, jasen_id) VALUES ('2', '2');
INSERT INTO Kokous_has_Jasen (kokous_id, jasen_id) VALUES ('2', '1');
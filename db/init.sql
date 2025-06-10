CREATE TABLE AIRPLANE (
 airline VARCHAR(10) NOT NULL,
 flightNo VARCHAR(10),
 departureDateTime TIMESTAMP,
 arrivalDateTime TIMESTAMP NOT NULL, 
 departureAirport VARCHAR(20) NOT NULL,
 arrivalAirport VARCHAR(20) NOT NULL,
 CONSTRAINT pk_airplane PRIMARY KEY(flightNo, departureDateTime)
);

CREATE TABLE SEATS (
 flightNo VARCHAR(10),
 departureDateTime TIMESTAMP,
 seatClass VARCHAR(10), 
 price NUMBER NOT NULL,
 no_of_seats NUMBER NOT NULL,
 CONSTRAINT pk_seats PRIMARY KEY(flightNo, departureDateTime,seatClass),
 CONSTRAINT fk_seats FOREIGN KEY(flightNo, departureDateTime)
    REFERENCES AIRPLANE(flightNo, departureDateTime)
);

CREATE TABLE CUSTOMER (
 cno VARCHAR(10),
 name VARCHAR(100) NOT NULL,
 passwd VARCHAR(100) NOT NULL,
 email VARCHAR(40) NOT NULL,
 passportNumber VARCHAR(9),
 CONSTRAINT pk_customer PRIMARY KEY(cno)
);

CREATE TABLE RESERVE (
 flightNo VARCHAR(10),
 departureDateTime TIMESTAMP,
 seatClass VARCHAR(10), 
 payment NUMBER NOT NULL,
 reserveDateTime TIMESTAMP NOT NULL,
 cno VARCHAR(10),
 CONSTRAINT pk_reserve PRIMARY KEY(flightNo, departureDateTime,seatClass, cno),
 CONSTRAINT fk_reserve1 FOREIGN KEY(flightNo, departureDateTime, seatClass) 
  REFERENCES SEATS(flightNo, departureDateTime, seatClass),
 CONSTRAINT fk_reserve2 FOREIGN KEY(cno) 
  REFERENCES CUSTOMER(cno)
);

CREATE TABLE CANCEL (
 flightNo VARCHAR(10),
 departureDateTime TIMESTAMP,
 seatClass VARCHAR(10), 
 refund NUMBER NOT NULL,
 cancelDateTime TIMESTAMP NOT NULL,
 cno VARCHAR(10),
 CONSTRAINT pk_cancel PRIMARY KEY(flightNo, departureDateTime,seatClass, cno),
 CONSTRAINT fk_cancel1 FOREIGN KEY(flightNo, departureDateTime, seatClass) 
  REFERENCES SEATS(flightNo, departureDateTime, seatClass),
 CONSTRAINT fk_cancel2 FOREIGN KEY(cno) 
  REFERENCES CUSTOMER(cno)
);

INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('KAL', 'F001', TO_TIMESTAMP('2025-10-01 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-01 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('JAL', 'F002', TO_TIMESTAMP('2025-10-01 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-01 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('ANA', 'F003', TO_TIMESTAMP('2025-10-01 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-01 12:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('ASI', 'F004', TO_TIMESTAMP('2025-10-01 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-01 13:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('KAL', 'F005', TO_TIMESTAMP('2025-10-02 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-02 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('JAL', 'F006', TO_TIMESTAMP('2025-10-02 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-02 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('ANA', 'F007', TO_TIMESTAMP('2025-10-02 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-02 12:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('ASI', 'F008', TO_TIMESTAMP('2025-10-02 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-02 13:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('KAL', 'F009', TO_TIMESTAMP('2025-10-03 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-03 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('JAL', 'F010', TO_TIMESTAMP('2025-10-03 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-03 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('ANA', 'F011', TO_TIMESTAMP('2025-10-03 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-03 12:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('ASI', 'F012', TO_TIMESTAMP('2025-10-03 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-03 13:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('KAL', 'F013', TO_TIMESTAMP('2025-10-04 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-04 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('JAL', 'F014', TO_TIMESTAMP('2025-10-04 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-04 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('ANA', 'F015', TO_TIMESTAMP('2025-10-04 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-04 12:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('ASI', 'F016', TO_TIMESTAMP('2025-10-04 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-04 13:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('KAL', 'F017', TO_TIMESTAMP('2025-10-05 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-05 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('JAL', 'F018', TO_TIMESTAMP('2025-10-05 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-05 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('ANA', 'F019', TO_TIMESTAMP('2025-10-05 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-05 12:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('ASI', 'F020', TO_TIMESTAMP('2025-10-05 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-05 13:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('KAL', 'F021', TO_TIMESTAMP('2025-10-06 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-06 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('JAL', 'F022', TO_TIMESTAMP('2025-10-06 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-06 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('ANA', 'F023', TO_TIMESTAMP('2025-10-06 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-06 12:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('ASI', 'F024', TO_TIMESTAMP('2025-10-06 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-06 13:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('KAL', 'F025', TO_TIMESTAMP('2025-10-07 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-07 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('JAL', 'F026', TO_TIMESTAMP('2025-10-07 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-07 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('ANA', 'F027', TO_TIMESTAMP('2025-10-07 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-07 12:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('ASI', 'F028', TO_TIMESTAMP('2025-10-07 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-07 13:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('KAL', 'F029', TO_TIMESTAMP('2025-10-08 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-08 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('JAL', 'F030', TO_TIMESTAMP('2025-10-08 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-10-08 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');
INSERT INTO AIRPLANE (airline, flightNo, departureDateTime, arrivalDateTime, departureAirport, arrivalAirport) VALUES ('JAL', 'F031', TO_TIMESTAMP('2025-06-09 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), TO_TIMESTAMP('2025-06-09 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'ICN', 'NRT');

-- SELECT * FROM AIRPLANE;

INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F001', TO_TIMESTAMP('2025-10-01 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 642176, 155);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F002', TO_TIMESTAMP('2025-10-01 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 655099, 133);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F003', TO_TIMESTAMP('2025-10-01 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 586534, 196);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F003', TO_TIMESTAMP('2025-10-01 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1105221, 97);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F004', TO_TIMESTAMP('2025-10-01 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1209824, 54);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F004', TO_TIMESTAMP('2025-10-01 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 604227, 110);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F005', TO_TIMESTAMP('2025-10-02 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 518488, 143);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F006', TO_TIMESTAMP('2025-10-02 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 567920, 174);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F006', TO_TIMESTAMP('2025-10-02 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1082108, 54);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F007', TO_TIMESTAMP('2025-10-02 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1364992, 76);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F008', TO_TIMESTAMP('2025-10-02 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 698366, 166);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F008', TO_TIMESTAMP('2025-10-02 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1297250, 60);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F009', TO_TIMESTAMP('2025-10-03 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1072769, 83);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F010', TO_TIMESTAMP('2025-10-03 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 506292, 133);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F010', TO_TIMESTAMP('2025-10-03 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1392021, 75);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F011', TO_TIMESTAMP('2025-10-03 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1290297, 71);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F011', TO_TIMESTAMP('2025-10-03 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 563390, 129);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F012', TO_TIMESTAMP('2025-10-03 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 565693, 171);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F012', TO_TIMESTAMP('2025-10-03 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1365152, 63);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F013', TO_TIMESTAMP('2025-10-04 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1294568, 84);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F014', TO_TIMESTAMP('2025-10-04 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1344059, 54);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F014', TO_TIMESTAMP('2025-10-04 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 544920, 110);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F015', TO_TIMESTAMP('2025-10-04 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1129010, 59);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F015', TO_TIMESTAMP('2025-10-04 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 601026, 106);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F016', TO_TIMESTAMP('2025-10-04 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 659624, 142);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F016', TO_TIMESTAMP('2025-10-04 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1288879, 74);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F017', TO_TIMESTAMP('2025-10-05 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1374400, 69);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F018', TO_TIMESTAMP('2025-10-05 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 632691, 160);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F018', TO_TIMESTAMP('2025-10-05 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1063680, 96);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F019', TO_TIMESTAMP('2025-10-05 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1245160, 52);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F020', TO_TIMESTAMP('2025-10-05 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 524464, 177);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F020', TO_TIMESTAMP('2025-10-05 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1262481, 95);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F021', TO_TIMESTAMP('2025-10-06 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1060467, 51);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F022', TO_TIMESTAMP('2025-10-06 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 633144, 149);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F022', TO_TIMESTAMP('2025-10-06 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1230567, 74);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F023', TO_TIMESTAMP('2025-10-06 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 660123, 197);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F023', TO_TIMESTAMP('2025-10-06 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1090391, 89);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F024', TO_TIMESTAMP('2025-10-06 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 560956, 114);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F025', TO_TIMESTAMP('2025-10-07 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1174207, 74);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F025', TO_TIMESTAMP('2025-10-07 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 537610, 109);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F026', TO_TIMESTAMP('2025-10-07 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 697416, 168);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F026', TO_TIMESTAMP('2025-10-07 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1208922, 99);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F027', TO_TIMESTAMP('2025-10-07 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1119963, 87);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F028', TO_TIMESTAMP('2025-10-07 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 678655, 144);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F028', TO_TIMESTAMP('2025-10-07 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1373364, 71);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F029', TO_TIMESTAMP('2025-10-08 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 568201, 169);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F029', TO_TIMESTAMP('2025-10-08 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1194791, 55);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F030', TO_TIMESTAMP('2025-10-08 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1017808, 86);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F030', TO_TIMESTAMP('2025-10-08 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 600015, 198);
INSERT INTO SEATS (flightNo, departureDateTime, seatClass, price, no_of_seats) VALUES ('F031', TO_TIMESTAMP('2025-06-09 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 812356, 22);

-- SELECT * FROM SEATS;

INSERT INTO CUSTOMER (cno, name, passwd, email, passportNumber) VALUES ('c0', '관리자', 'admin123', 'admin@gmail.com', 'A12345678');
INSERT INTO CUSTOMER (cno, name, passwd, email, passportNumber) VALUES ('c1', '김철수', 'pass1234', 'cs.kim@gmail.com', 'B23456789');
INSERT INTO CUSTOMER (cno, name, passwd, email, passportNumber) VALUES ('c2', '이영희', 'pass2345', 'yh.lee@gmail.com', 'C34567890');
INSERT INTO CUSTOMER (cno, name, passwd, email, passportNumber) VALUES ('c3', '박민수', 'pass3456', 'ms.park@gmail.com', 'D45678901');
INSERT INTO CUSTOMER (cno, name, passwd, email, passportNumber) VALUES ('c4', '최수정', 'pass4567', 'sj.choi@gmail.com', 'E56789012');
INSERT INTO CUSTOMER (cno, name, passwd, email, passportNumber) VALUES ('c5', '장도윤', 'pass5678', 'dy.jang@gmail.com', 'F67890123');
INSERT INTO CUSTOMER (cno, name, passwd, email, passportNumber) VALUES ('c6', '한지민', 'pass6789', 'jm.han@gmail.com', 'G78901234');

-- SELECT * FROM CUSTOMER;

INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F031', TO_TIMESTAMP('2025-06-09 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 812356, TO_TIMESTAMP('2025-05-18 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c1');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F014', TO_TIMESTAMP('2025-10-04 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 544920, TO_TIMESTAMP('2025-10-03 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c5');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F014', TO_TIMESTAMP('2025-10-04 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 544920, TO_TIMESTAMP('2025-10-02 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c2');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F014', TO_TIMESTAMP('2025-10-04 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 544920, TO_TIMESTAMP('2025-09-30 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c4');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F014', TO_TIMESTAMP('2025-10-04 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 544920, TO_TIMESTAMP('2025-10-01 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c1');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F014', TO_TIMESTAMP('2025-10-04 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 544920, TO_TIMESTAMP('2025-10-01 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c6');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F014', TO_TIMESTAMP('2025-10-04 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 544920, TO_TIMESTAMP('2025-10-02 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c3');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F004', TO_TIMESTAMP('2025-10-01 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 604227, TO_TIMESTAMP('2025-09-28 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c2');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F004', TO_TIMESTAMP('2025-10-01 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 604227, TO_TIMESTAMP('2025-09-28 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c3');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F004', TO_TIMESTAMP('2025-10-01 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 604227, TO_TIMESTAMP('2025-09-26 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c1');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F004', TO_TIMESTAMP('2025-10-01 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 604227, TO_TIMESTAMP('2025-09-28 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c6');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F004', TO_TIMESTAMP('2025-10-01 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 604227, TO_TIMESTAMP('2025-09-30 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c5');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F003', TO_TIMESTAMP('2025-10-01 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 586534, TO_TIMESTAMP('2025-09-26 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c6');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F003', TO_TIMESTAMP('2025-10-01 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 586534, TO_TIMESTAMP('2025-09-28 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c4');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F003', TO_TIMESTAMP('2025-10-01 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 586534, TO_TIMESTAMP('2025-09-26 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c2');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F003', TO_TIMESTAMP('2025-10-01 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 586534, TO_TIMESTAMP('2025-09-29 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c5');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F003', TO_TIMESTAMP('2025-10-01 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 586534, TO_TIMESTAMP('2025-09-30 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c3');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F011', TO_TIMESTAMP('2025-10-03 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1290297, TO_TIMESTAMP('2025-09-29 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c1');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F011', TO_TIMESTAMP('2025-10-03 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1290297, TO_TIMESTAMP('2025-09-30 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c2');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F011', TO_TIMESTAMP('2025-10-03 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1290297, TO_TIMESTAMP('2025-09-29 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c3');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F011', TO_TIMESTAMP('2025-10-03 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1290297, TO_TIMESTAMP('2025-09-30 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c6');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F011', TO_TIMESTAMP('2025-10-03 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1290297, TO_TIMESTAMP('2025-10-01 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c4');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F011', TO_TIMESTAMP('2025-10-03 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1290297, TO_TIMESTAMP('2025-09-30 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c5');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F007', TO_TIMESTAMP('2025-10-02 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1364992, TO_TIMESTAMP('2025-09-27 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c2');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F007', TO_TIMESTAMP('2025-10-02 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1364992, TO_TIMESTAMP('2025-09-30 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c6');
INSERT INTO RESERVE (flightNo, departureDateTime, seatClass, payment, reserveDateTime, cno) VALUES ('F007', TO_TIMESTAMP('2025-10-02 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1364992, TO_TIMESTAMP('2025-09-30 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c4');

-- SELECT * FROM RESERVE;

INSERT INTO CANCEL (flightNo, departureDateTime, seatClass, refund, cancelDateTime, cno) VALUES ('F001', TO_TIMESTAMP('2025-10-01 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 392176, TO_TIMESTAMP('2025-09-29 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c3');
INSERT INTO CANCEL (flightNo, departureDateTime, seatClass, refund, cancelDateTime, cno) VALUES ('F002', TO_TIMESTAMP('2025-10-01 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 405099, TO_TIMESTAMP('2025-09-30 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c2');
INSERT INTO CANCEL (flightNo, departureDateTime, seatClass, refund, cancelDateTime, cno) VALUES ('F003', TO_TIMESTAMP('2025-10-01 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 406534, TO_TIMESTAMP('2025-09-24 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c1');
INSERT INTO CANCEL (flightNo, departureDateTime, seatClass, refund, cancelDateTime, cno) VALUES ('F003', TO_TIMESTAMP('2025-10-01 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 925221, TO_TIMESTAMP('2025-09-27 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c2');
INSERT INTO CANCEL (flightNo, departureDateTime, seatClass, refund, cancelDateTime, cno) VALUES ('F004', TO_TIMESTAMP('2025-10-01 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1029824, TO_TIMESTAMP('2025-09-26 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c5');
INSERT INTO CANCEL (flightNo, departureDateTime, seatClass, refund, cancelDateTime, cno) VALUES ('F004', TO_TIMESTAMP('2025-10-01 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 354227, TO_TIMESTAMP('2025-10-01 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c4');
INSERT INTO CANCEL (flightNo, departureDateTime, seatClass, refund, cancelDateTime, cno) VALUES ('F005', TO_TIMESTAMP('2025-10-02 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 338488, TO_TIMESTAMP('2025-09-27 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c2');
INSERT INTO CANCEL (flightNo, departureDateTime, seatClass, refund, cancelDateTime, cno) VALUES ('F006', TO_TIMESTAMP('2025-10-02 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 387920, TO_TIMESTAMP('2025-10-02 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c2');
INSERT INTO CANCEL (flightNo, departureDateTime, seatClass, refund, cancelDateTime, cno) VALUES ('F006', TO_TIMESTAMP('2025-10-02 09:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 902108, TO_TIMESTAMP('2025-09-29 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c4');
INSERT INTO CANCEL (flightNo, departureDateTime, seatClass, refund, cancelDateTime, cno) VALUES ('F007', TO_TIMESTAMP('2025-10-02 10:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1114992, TO_TIMESTAMP('2025-10-04 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c3');
INSERT INTO CANCEL (flightNo, departureDateTime, seatClass, refund, cancelDateTime, cno) VALUES ('F008', TO_TIMESTAMP('2025-10-02 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'economy', 448366, TO_TIMESTAMP('2025-10-06 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c5');
INSERT INTO CANCEL (flightNo, departureDateTime, seatClass, refund, cancelDateTime, cno) VALUES ('F008', TO_TIMESTAMP('2025-10-02 11:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'business', 1117250, TO_TIMESTAMP('2025-10-02 08:00:00', 'YYYY-MM-DD HH24:MI:SS'), 'c1');

-- SELECT * FROM CANCEL;
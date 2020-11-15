CREATE DATABASE CTIS;

CREATE TABLE TEST_CENTRE(
centreID VARCHAR(15) NOT NULL PRIMARY KEY,
/*centre name will be initialise by the test centre manager*/
centreName VARCHAR(50)
);

CREATE TABLE CENTRE_OFFICER(
/*
manager id start with M as example M0001
*/
officerID VARCHAR(20) PRIMARY KEY NOT NULL,
officerPwsd VARCHAR(15) NOT NULL DEFAULT 'abc123',
officerName VARCHAR(50) NOT NULL,
/*
position
0 - tester 
1 - manager
*/
position int(1) NOT NULL,
centreID VARCHAR(15) NOT NULL,/*test centre which the officer works in*/
CONSTRAINT officer_fk1 FOREIGN KEY(centreID) REFERENCES TEST_CENTRE(centreID) ON UPDATE CASCADE
); 

CREATE TABLE TESTKIT(
testName VARCHAR(50) NOT NULL,
kitID VARCHAR(15) NOT NULL PRIMARY KEY
);

/*TESTKIT and TEST_CENTRE has many to many relationship
because other test centre might has the same testkit */
CREATE TABLE TEST_CENTRE_TESTKIT(
centreID VARCHAR(15) NOT NULL,
kitID VARCHAR(15) NOT NULL,
availableStock int(5) NOT NULL,
CONSTRAINT stock_fk1 FOREIGN KEY(centreID) REFERENCES TEST_CENTRE(centreID) ON UPDATE CASCADE,
CONSTRAINT stock_fk2 FOREIGN KEY(kitID) REFERENCES TESTKIT(kitID) ON UPDATE CASCADE,
CONSTRAINT stock_pk1 PRIMARY KEY(centreID,kitID)
);

CREATE TABLE PATIENT(
patName VARCHAR(50) NOT NULL,
patUsername VARCHAR(20) NOT NULL PRIMARY KEY,
patPwsd VARCHAR(25) NOT NULL
);

CREATE TABLE TEST(
testID VARCHAR(20) NOT NULL PRIMARY KEY,
testDate DATETIME NOT NULL,
/*
Patient type
1-returnee
2-quarantined
3-close contact
4-infected
5-suspected
*/
patType int(1) NOT NULL,
symptoms VARCHAR(100) NOT NULL,
/*
status
0 - pending
1 - completed
*/
status int(1) NOT NULL,
/*
result
0 - negative
1 - positive
*/
result int(1),
resultDate DATETIME,
patUsername VARCHAR(20) NOT NULL,
/*Test stores centreID to know where is the test taken
Because patient might take covid test in different test centre*/
centreID VARCHAR(15) NOT NULL,
CONSTRAINT test_fk1 FOREIGN KEY (patUsername) REFERENCES PATIENT (patUsername) ON UPDATE CASCADE,
CONSTRAINT test_fk2 FOREIGN KEY(centreID) REFERENCES TEST_CENTRE(centreID) ON UPDATE CASCADE
);

/* Table for record the contact message */
CREATE TABLE CONTACT(
email VARCHAR(50) NOT NULL,
name VARCHAR(50) NOT NULL,
message TEXT NOT NULL,
msgDate DATETIME NOT NULL
);

/*Insert some dummy datas*/
INSERT INTO TEST_CENTRE (centreID,centreName) VALUES ('C0001','Ali Test Centre');
INSERT INTO TEST_CENTRE (centreID) VALUES ('C0002');
INSERT INTO TEST_CENTRE (centreID) VALUES ('C0003');
INSERT INTO TEST_CENTRE (centreID) VALUES ('C0004');
INSERT INTO TEST_CENTRE (centreID) VALUES ('C0005');
INSERT INTO TEST_CENTRE (centreID) VALUES ('C0006');
INSERT INTO TEST_CENTRE (centreID) VALUES ('C0007');
INSERT INTO TEST_CENTRE (centreID) VALUES ('C0008');
INSERT INTO TEST_CENTRE (centreID) VALUES ('C0009');
INSERT INTO TEST_CENTRE (centreID) VALUES ('C0010');

INSERT INTO CENTRE_OFFICER (officerID, position, centreID,officerName) VALUES ('M0001',1,'C0001','Yasmeen Reed');
INSERT INTO CENTRE_OFFICER (officerID, position, centreID,officerName) VALUES ('M0002',1,'C0002','Kris Shah');
INSERT INTO CENTRE_OFFICER (officerID, position, centreID,officerName) VALUES ('M0003',1,'C0003','Arda Wiggins');
INSERT INTO CENTRE_OFFICER (officerID, position, centreID,officerName) VALUES ('M0004',1,'C0004','Ronaldo Wallis');
INSERT INTO CENTRE_OFFICER (officerID, position, centreID,officerName) VALUES ('M0005',1,'C0005','Ksawery Greenaway');
INSERT INTO CENTRE_OFFICER (officerID, position, centreID,officerName) VALUES ('M0006',1,'C0006','Kerrie Morrow');
INSERT INTO CENTRE_OFFICER (officerID, position, centreID,officerName) VALUES ('M0007',1,'C0007','Atlanta Easton');
INSERT INTO CENTRE_OFFICER (officerID, position, centreID,officerName) VALUES ('M0008',1,'C0008','Tate Love');
INSERT INTO CENTRE_OFFICER (officerID, position, centreID,officerName) VALUES ('M0009',1,'C0009','Griffin Howell');
INSERT INTO CENTRE_OFFICER (officerID, position, centreID,officerName) VALUES ('M0010',1,'C0010','Cory Barrow');

INSERT INTO TESTKIT (kitID,testName) VALUES ('T0001','CoV-1');
INSERT INTO TESTKIT (kitID,testName) VALUES ('T0002','CoV-2');
INSERT INTO TESTKIT (kitID,testName) VALUES ('T0003','Flu SC2 Multiplex Assay');
INSERT INTO TESTKIT (kitID,testName) VALUES ('T0004','RT-PCR');
INSERT INTO TESTKIT (kitID,testName) VALUES ('T0005','CoV-3');

INSERT INTO TEST_CENTRE_TESTKIT (centreID,kitID,availableStock) VALUES('C0001','T0001',5);
INSERT INTO TEST_CENTRE_TESTKIT (centreID,kitID,availableStock) VALUES('C0001','T0002',14);

INSERT INTO PATIENT (patName,patUsername,patPwsd) VALUES ('Kaira Clark','KARK0512','abc123');
INSERT INTO PATIENT (patName,patUsername,patPwsd) VALUES ('Jevon Southern','JERN0414','abc123');
INSERT INTO PATIENT (patName,patUsername,patPwsd) VALUES ('Jaydan Ho','JNHO0625','abc123');
INSERT INTO PATIENT (patName,patUsername,patPwsd) VALUES ('Maximilian Hale','MALE0214','abc123');
INSERT INTO PATIENT (patName,patUsername,patPwsd) VALUES ('Raihan Gilliam','RIAM0804','abc123');

INSERT INTO TEST (testID,testDate,patType,symptoms,status,patUsername,centreID) VALUES ('TCG12200304','2020-01-11 12:25:01',1,'too happy',0,'KARK0512','C0001');
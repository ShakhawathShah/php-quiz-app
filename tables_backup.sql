CREATE DATABASE IF NOT EXISTS testdb;

CREATE TABLE IF NOT EXISTS student(
    stud_ID varChar (100) NOT NULL, 
    fname varChar (100) NOT NULL,  
    sname varChar (100) NOT NULL,  
    pass varChar (100) NOT NULL,  
    PRIMARY KEY(stud_ID)
);

CREATE TABLE IF NOT EXISTS staff(
    staff_ID varChar (100) NOT NULL, 
    fname varChar (100) NOT NULL,  
    sname varChar (100) NOT NULL,  
    pass varChar (100) NOT NULL,  
    PRIMARY KEY(staff_ID)
);

CREATE TABLE IF NOT EXISTS quizDetails(
    quiz_ID int UNSIGNED NOT NULL AUTO_INCREMENT,
    staff_ID varChar (100) NOT NULL, 
    quiz_name varChar (100), 
    duration smallint,
    total_score smallint,
    PRIMARY KEY(quiz_ID, staff_ID),
    FOREIGN KEY(staff_ID) REFERENCES staff(staff_ID) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS studentInfo(
    stud_ID varChar (100) NOT NULL, 
    quiz_ID int UNSIGNED NOT NULL,
    available varChar (10),  
    date_attempted datetime,  
    score smallint,
    PRIMARY KEY(stud_ID, quiz_ID),
    FOREIGN KEY (stud_ID) REFERENCES student(stud_ID) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (quiz_ID) REFERENCES quizDetails(quiz_ID) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS questions(
    question_num int NOT NULL AUTO_INCREMENT, 
    quiz_ID int UNSIGNED NOT NULL,
    question varChar (100),
    PRIMARY KEY(question_num, quiz_ID),
    FOREIGN KEY(quiz_ID) REFERENCES quizDetails(quiz_ID) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS options(
    question_option varChar(100) NOT NULL,
    quiz_ID int UNSIGNED NOT NULL,
    question_num int NOT NULL, 
    option_chosen varChar(100),
    correct boolean,
    PRIMARY KEY(question_option, quiz_ID, question_num),
    FOREIGN KEY(quiz_ID) REFERENCES quizDetails(quiz_ID) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY(question_num) REFERENCES questions(question_num) ON UPDATE CASCADE ON DELETE CASCADE
);
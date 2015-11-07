
CREATE TABLE Person (
    id SERIAL PRIMARY KEY,
    name varchar(30) UNIQUE NOT NULL,
    password varchar(30) NOT NULL
);

CREATE TABLE Category (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES Person(id) NOT NULL,
    name varchar(255) NOT NULL,
    description varchar(2000)
);

CREATE TABLE Task (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES Person(id) NOT NULL,
    priority INTEGER NOT NULL DEFAULT 0,
    deadline DATE NOT NULL,
    completed boolean DEFAULT FALSE,
    name varchar(255) NOT NULL,
    description varchar(2000)
);

CREATE TABLE TaskCategory (
    task_id INTEGER REFERENCES Task(id) NOT NULL,
    category_id INTEGER REFERENCES Category(id) NOT NULL,
    PRIMARY KEY (task_id, category_id)
);

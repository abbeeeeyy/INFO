CREATE TABLE movies(
    movie_id INT AUTO_INCREMENT PRIMARY KEY,
    movie_name VARCHAR(255) NOT NULL,
    poster_link VARCHAR(255) NOT NULL,
    trailer_link VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    runtime VARCHAR(10) NOT NULL
);
INSERT INTO movies (movie_name, poster_link, trailer_link, description, runtime) VALUES
('Wicked', 'movieposter1', '6COmYeLsz4c?', 'Elphaba, a misunderstood young woman because of her green skin, and Glinda, a popular girl, become friends at Shiz University in the Land of Oz. After an encounter with the Wonderful Wizard of Oz, their friendship reaches a crossroads.', '2h 40m'),
('Smile 2', 'movieposter2', '0HY6QFlBzUY?', 'About to embark on a world tour, global pop sensation Skye Riley begins experiencing increasingly terrifying and inexplicable events. Overwhelmed by the escalating horrors and the pressures of fame, Skye is forced to face her past.', '2h 12m'),
('Moana 2', 'movieposter3', 'hDZ7y8RP5HE?', 'After receiving an unexpected call from her wayfinding ancestors, Moana must journey to the far seas of Oceania and into dangerous, long-lost waters for an adventure unlike anything she\'s ever faced.', '1h 40m'),
('The Wild Robot', 'movieposter4', '67vbA5ZJdKQ?', 'After a shipwreck, an intelligent robot called Roz is stranded on an uninhabited island. To survive the harsh environment, Roz bonds with the island\'s animals and cares for an orphaned baby goose.', '1h 42m'),
('The Idea of You', 'movieposter5', 'V8i6PB0gGOA?', 'Solène, a 40-year-old single mom, begins an unexpected romance with 24-year-old Hayes Campbell, the lead singer of August Moon, the hottest boy band on the planet.', '1h 55m'),
('Hello, Love, Again', 'movieposter6', 'uRBHJPic9zc?', 'After fighting for their love to conquer the time, distance and a global shutdown that kept them apart, Joy and Ethan meet again in Canada but realize that they have also changed a lot, individually.', '2h 2m'),
('And The Breadwinner is...', 'movieposter7', 'l1OiWrv5gFY?', 'The film will focus on Bambi Salvador, a breadwinner working as an OFW in Taiwan for her family back home. She then returns home to Arayat, Pampanga expecting for her dream house to be finished, instead returns to see their dilapidated house. They restarts "Papsy\'s Panaderyuh, Home of the Original Kalil", a bakery shops and funeral parlor. The film serves as a tribute to the unsung heroes who carry the weight of their loved ones\' dreams on their shoulders.', '2h 3m'),
('My Future You', 'movieposter8', '7rgVgstJ7Mk?', 'Karen (Francine Diaz) and Lex (Seth Fedelin) meets each other in an online dating app. They live in two different timelines set fifteen years apart whose connection was made possible through a comet. After learning their strange situation they work on changing the past to alter their fate', '1h 49m'),
('Hold Me Close', 'movieposter9', 'UMpObYt90_A?', 'Woody has spent seven years travelling across the world to find a place to settle. He checks out Japan where he meets Lynlyn, who has the special ability to tell if a certain person will cause happiness or harm to her by merely touching them', '1h 38m'),
('Espantaho', 'movieposter10', 'ZJ84Aug0pok?', 'The story of Monet and her mother Rosa, who are mourning over the death of the family patriarch Pabling. During the nine days of pasiyam, dark secrets and a malevolent plot start to unravel.', '1h 30m'),
('Mufasa', 'movieposter11', 'o17MF9vnabg?', 'Mufasa, a cub lost and alone, meets a sympathetic lion named Taka, the heir to a royal bloodline. The chance meeting sets in motion an expansive journey of a group of misfits searching for their destiny.', '1h 58m'),
('Bocchi The Rock! Recap Part 2', 'movieposter12', 'Ocvxy8YwuCE?', 'The 2022 hit animated television series "Bocchi Za Rokku!" re-edited for film. The film, which also attracted a great deal of attention in terms of music, with the full album "KESSOKU BAND" ranking first in Oricon\'s "Digital Album Ranking by Number of Sales by Production" in 2023, will be revived on the movie theater screen.', '1h 15m');


CREATE TABLE directors(
    director_id INT AUTO_INCREMENT PRIMARY KEY,
    director_name VARCHAR(255) NOT NULL
);
INSERT INTO directors (director_name) VALUES
('Jon M. Chu'),
('Parker Finn'),
('David G. Derrick Jr.'),
('Jason Hand'),
('Dana Ledoux Miller'),
('Chris Sanders'),
('Michael Showalter'),
('Cathy Garcia-Sampana'),
('Jun R. Lana'),
('Crisanto B. Aquino'),
('Jason Paul Laxamana'),
('Chito S. Roño'),
('Barry Jenkins'),
('Keiichiro Saitō');


CREATE TABLE casts(
    cast_id INT AUTO_INCREMENT PRIMARY KEY,
    cast_name VARCHAR(255) NOT NULL
);
INSERT INTO casts (cast_name) VALUES
('Cynthia Erivo'),
('Ariana Grande'),
('Jeff Goldblum'),
('Naomi Scott'),
('Rosemarie DeWitt'),
('Lukas Gage'),
('Auli\'i Cravalho'),
('Dwayne Johnson'),
('Hualalai Chung'),
('Lupita Nyong\'o'),
('Pedro Pascal'),
('Kit Connor'),
('Anne Hathaway'),
('Nicholas Galitzine'),
('Ella Rubin'),
('Kathryn Bernardo'),
('Alden Richards'),
('Joross Gamboa'),
('Vice Ganda'),
('Eugene Domingo'),
('Francine Diaz'),
('Seth Fedelin'),
('Julia Barreto'),
('Carlo Aquino'),
('Judy Ann Santos'),
('Lorna Tolentino'),
('Aaron Pierre'),
('Kelvin Harrison Jr.'),
('Tiffany Boone'),
('Yoshino Aoyama'),
('Sayumi Suzushiro'),
('Saku Mizuno');


CREATE TABLE genres(
    genre_id INT AUTO_INCREMENT PRIMARY KEY,
    genre_name VARCHAR(255) NOT NULL
);
INSERT INTO genres (genre_name) VALUES
('Fantasy'),
('Musical'),
('Romance'),
('Horror'),
('Mystery'),
('Thriller'),
('Animation'),
('Adventure'),
('Comedy'),
('Sci-fi'),
('Fiction'),
('Contemporary'),
('Drama'),
('Family'),
('Supernatural'),
('Music');


CREATE TABLE aboutmovie(
    movie_id INT NOT NULL,
    director_id INT NOT NULL,
    cast_id INT NOT NULL,
    genre_id INT NOT NULL,
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id),
    FOREIGN KEY (director_id) REFERENCES directors(director_id),
    FOREIGN KEY (cast_id) REFERENCES casts(cast_id),
    FOREIGN KEY (genre_id) REFERENCES genres(genre_id)
);
INSERT INTO aboutmovie(movie_id, director_id, cast_id, genre_id) VALUES
('1','1','1','1'),
('1', '1', '2', '2'),
('1', '1', '3', '3'),
('2', '2', '4', '4'),
('2', '2', '5', '5'),
('2', '2', '6', '6'),
('3', '3', '7', '7'),
('3', '4', '8', '8'),
('3', '5', '9', '9'),
('4', '6', '10', '7'),
('4', '6', '11', '10'),
('4', '6', '12', '8'),
('5', '7', '13', '3'),
('5', '7', '14', '11'),
('5', '7', '15', '12'),
('6', '8', '16', '13'),
('6', '8', '17', '3'),
('6', '8', '18', '3'),
('7', '9', '19', '14'),
('7', '9', '20', '13'),
('7', '9', '20', '9'),
('8', '10', '21', '3'),
('8', '10', '22', '9'),
('8', '10', '22', '1'),
('9', '11', '23', '4'),
('9', '11', '24', '1'),
('10', '12', '25', '4'),
('10', '12', '26', '15'),
('11', '13', '27', '7'),
('11', '13', '28', '8'),
('11', '13', '29', '13'),
('12', '14', '30', '13'),
('12', '14', '31', '9'),
('12', '14', '32', '16');


SELECT 
	m.movie_id,
    m.movie_name,
    m.poster_link,
    m.trailer_link,
    m.description,
    d.director_name,
    c.cast_name,
    m.runtime,
    g.genre_name
FROM 
    aboutmovie am
JOIN 
    movies m ON am.movie_id = m.movie_id
JOIN 
    directors d ON am.director_id = d.director_id
JOIN 
    casts c ON am.cast_id = c.cast_id
JOIN 
    genres g ON am.genre_id = g.genre_id;


CREATE TABLE users(
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_firstname VARCHAR(255) NOT NULL,
    user_lastname VARCHAR(255) NOT NULL,
    user_email VARCHAR(255) NOT NULL,
    user_pass VARCHAR(20) NOT NULL
);
INSERT INTO users (user_firstname, user_lastname, user_email, user_pass) VALUES
('Franchesca', 'Tejada', 'chescatejada@gmail.com', 'chescatejada'),
('Bea', 'Parman', 'beaparman@gmail.com', 'beaparman'),
('Guillana', 'Ronquillo', 'yanaronquillo@gmail.com', 'yanaronquillo'),
('Troy', 'Pasiwen', 'troypasiwen@gmail.com', 'troypasiwen');


CREATE TABLE admins(
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    admin_firstname VARCHAR(255) NOT NULL,
    admin_lastname VARCHAR(255) NOT NULL,
    admin_email VARCHAR(255) NOT NULL,
    admin_pass VARCHAR(20) NOT NULL
);
INSERT INTO admins (admin_firstname, admin_lastname, admin_email, admin_pass) VALUES
('Max', 'Parilla', 'maxparilla@gmail.com', 'maxparilla'),
('Abigail', 'Borromeo', 'abiborromeo@gmail.com', 'abiborromeo'),
('Chloe', 'De Leon', 'chloedeleon@gmail.com', 'chloedeleon'),
('Daniella', 'Morilla', 'danmorilla@gmail.com', 'danmorilla');

CREATE TABLE bookings(
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    phone_number VARCHAR(11) NOT NULL,
    booking_date DATE NOT NULL,
    no_of_tickets INT NOT NULL,
    payment_method VARCHAR(50) NOT NULL
);

CREATE TABLE moviebookings(
    movie_id INT NOT NULL,
    booking_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id),
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
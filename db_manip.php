<?php
include '../database.php';

// CREATE TABLE
function createTable() {
    $eventsTable = "
        CREATE TABLE IF NOT EXISTS `ugrp_events` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `start_time` time,
        `end_time` time,
        `event_date` date,
        `location` varchar(255),
        `title` varchar(255),
        `description` varchar(255),
        `event_type` ENUM('poster','paper','performance','schedule'),
        `presenters` varchar(255),
        PRIMARY KEY (`id`))";
        
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->query($eventsTable);
    Database::disconnect();
}

// POPULATE TABLE
function populateTable() {
    // POSTER PRESENTATION
    $poster1 = "
        INSERT INTO ugrp_events (start_time, end_time, event_date, location, title, description, event_type, presenters) 
        VALUES ('','','','1st Floor','Taking Refuge in Michigan: Arab American Women\'s Health Needs Assessment','Michigan has one of the largest refugee populations in the US, particularly refugees from the Middle East, North Africa, and the Horn of Africa. Refugees may have greater health needs as a result of violence in their countries of origin and their displacement. There is a moral imperative to try to provide for their health and well-being. A problem community agencies face is obtaining accurate information to address refugee health needs, particularly the needs of women. This project directly addresses that problem by proposing a community research project with ACCESS, one of the largest nonprofit social service organizations working with Arab and refugee populations in Michigan. This pilot project is a refugee women’s needs assessment performed by constructing an appropriate research instrument and interviewing 20 refugee women. Three SVSU students have engaged in learning about the process of doing research, abided by human subjects review/IRB, gained cross-cultural competency skills, and improved analysis and academic writing abilities in the course of this research project. The outcomes include scientific publications, recommendations for a larger study and for additional or changes in services that may help refugee women, if implemented.','poster','Students: Kristi Neal, Alexandrya Weiss, Linda Zitouni<br /> Faculty: Rosina Hassoun, PhD')";
    $poster2 = "
        INSERT INTO ugrp_events (start_time, end_time, event_date, location, title, description, event_type, presenters) 
        VALUES ('','','','2nd floor','Electrochemical investigation of tris(triphenylphosphine)rhodium(I) chloride and its analogues utilizing cyclic voltammetry','The complex tris(triphenylphosphine)rhodium(I) chloride is a well-known and extensively studied complex. It is known for the wide range of reactions that it can be involved in; most notably it catalyzes the hydrogenation of dienes to alkanes. An area of interest that lacks in current literature are the redox properties of tris(triphenylphosphine)rhodium(I) chloride and its analogues. Our focus is to expand the knowledge of these complexes, more specifically, with respect to their first oxidation potential. Our group set out to investigate the electrochemical, and spectroelectrochemical properties of this complex as well as its analogues. The redox properties of these complexes have been examined utilizing cyclic voltammetry (CV) techniques. The extensive CV experimentation includes the utilization of screen printed platinum and glassy carbon disk electrodes, as well as varying temperatures.','poster','Becky Calangelo, Jacob Turner, Brad Ross, Andrea Weinrick, Dr. Adam Warhausen')";
    $poster3 = "
        INSERT INTO ugrp_events (start_time, end_time, event_date, location, title, description, event_type, presenters) 
        VALUES ('','','','Groening Commons - Second Floor 2nd floor','Synthesis, characterization, electrtochemisty, and spectroelectrochemistry of iron-salophen-hydroxamate complexes','Interactions between nitric oxide and biologically available materials have been widely studied in the field of chemistry. Fortunately, there is much more to learn and to study about organic molecules that are capable of producing nitric oxide within living organisms. The nitic oxide donating molecules utilized in this research are hydroxamic acids. This project aims to study the interactions of these hydroxamic acids with iron- containing biomolecular models. The emphasis of this work focuses on understanding their redox behavior using electrochemical and spectroelectrochemical methods.','poster','Brad Ross, Taylor Syring, and Dr. Adam Warhausen')";
    
    // PAPER PRESENTATION
    $paper1 = "
        INSERT INTO ugrp_events (start_time, end_time, event_date, location, title, description, event_type, presenters) 
        VALUES ('','','','C102','Growth Investment Strategies Generating Risk-Adjusted Returns','The purpose of this project is to research and test growth investment strategies that generate superior risk-adjusted returns. A wide variety of statistical procedures have been applied including sound techniques of selecting and analyzing data. The primary purpose of the research is not to achieve individual wealth but rather to use an application of the model for generating funds for SVSU student scholarships. The overall value changes for the model are mostly independent of the broader stock market movements. Specifically, the stock selection process uses a hedge fund long/short strategy. It is not based on the popular “day-trading\" or “buy-and-hold\" approaches. The model does not require a prediction of future market performance, since theoretically it should perform better than the S&P 500 benchmark in both a bull and bear market. Its market-neutral approach consists of buying 10 stocks long and shorting 10 other stocks in such a way that portfolio risk is minimized. The research project uses various sources and databases for stock selection. These stocks are evaluated for both fundamental and quantitative factors. The former highlights accounting criteria while the latter captures institutional demand for the stocks. While the results for an individual year may vary, the goal is risk-adjusted returns over time compared to the overall market. We use standard measures of risk to assess the results. The main model has been able to outperform the the S&P 500 11.02% to 9.76% annually and has consistently achieved a higher Sharpe ratio of 3.7 to 2.07 over the S&P 500.','paper','Juan Sancen, Curtis Grosse')";
    $paper2 = "
        INSERT INTO ugrp_events (start_time, end_time, event_date, location, title, description, event_type, presenters) 
        VALUES ('','','','Seminar D','A Study of Writing Center Tutors’ Perceptions of their ESL Peers','As the number of English as a Second Language (ESL) speakers in the university setting increases, the number of these students who visit writing centers has increased dramatically as well. This influx brings to the forefront discussions about the way tutors handle sessions with ESL writers. This presentation will share initial results of an analysis of tutors’ session records, used to examine tutors’ perceptions about ESL tutorial sessions and the degree to which these perceptions dictate what happens in these sessions. Using a sample of session records maintained by the Writing Center at Saginaw Valley State University (SVSU) for AY 2014-15, this presentation will provide qualitative analysis of what help ESL students request before beginning a tutorial session in the Writing Center, and the analysis of what help the tutor provided at the end of the tutorial session. In addition, this presentation will code the written reflective comments of the tutors after their sessions with ESL writers to determine tutors’ perceptions about their work with ESL students. Additionally, this qualitative and quantitative data will be compared to a randomized set of session records conducted with native speakers of English who visit the SVSU Writing Center. This presentation will conclude with a discussion of best practices when working with ESL students and ways to combat assumptions made about the writing on ESL students, allowing us to create “not just better papers, but better writers”—regardless of their native tongue.','paper','Alison Barger, Dr. Veronika Drake')";
    $paper3 = "
        INSERT INTO ugrp_events (start_time, end_time, event_date, location, title, description, event_type, presenters) 
        VALUES ('','','','Seminar D','Utilizing Board Games in the Teaching of International Politics','This paper investigates the applicability of semi-complex off-the-shelves board games to classroom teaching. Specifically, we examine if employing board games as an active learning tool may help students empathize with decision-makers, and through empathy rooted in their personal experience, they come to an increased understanding about the pressures, dilemmas, and responsibilities that political leaders face in a continuously changing international political environment. We used an experimental setting involving 19 students playing the second editions of the Game of Thrones board game. We have collected both quantified and qualitative data (pre- and post-event surveys, simulation report, and classroom discussion) in order to assess the impact of the game playing experience on learning about the approaches of foreign policy decision-making. Providing a preliminary analysis based on qualitative data, we show that students were capable of drawing parallels between their game-playing and statesmen after experiencing the emotional, cognitive, and situational aspects of the decision-making process.','paper','Taylor Pierson and Agnes Simon')";

    // PERFORMANCE PRESENTATION
    $performance1 = "
        INSERT INTO ugrp_events (start_time, end_time, event_date, location, title, description, event_type, presenters) 
        VALUES ('','','','Rhea Miller Recital Hall','Metal Coils and Chronic Conditions: The Reality of Essure','In 2002 the Food and Drug Administration (FDA) approved a new form of permanent birth control called Essure. Inserted into a women\'s fallopian tubes, this small coil-like device causes scar tissue to block a women\'s eggs from reaching her uterus. The insertion of this device can be completed in a doctor\'s office without anesthesia, promising to be a safer alternative to traditional surgical sterilization methods. However, since Essure became widely available, thousands of women have filed reports of adverse health effects with the FDA. These side effects range from abdominal cramps, vomiting, and infection to more serious complications such as breakage of the coils. An analysis of these problems reveals two primary causes, hasty FDA approval and poor communication between manufacturers, doctors, and patients. Although manufactures of Essure have made some improvements to promotional material by including a longer list of side effects, this step is not enough to assure the safety of the women who use Essure. Essure needs to be removed from the commercial market and extensive research must be conducted. In this persuasive argument, the problems associated with Essure, their causes, and solutions are critically evaluated. A version of this speech was presented in the final round of the Sims Public Speaking Competition (November, 2015), was awarded first place at the Michigan Intercollegiate Speech League (MISL) Novice State Tournament (February, 2016), and won Top Novice at the MISL State Tournament (March, 2016).','performance','Melinda Dinninger, Dr. Amy Pierce')";
    $performance2 = "
        INSERT INTO ugrp_events (start_time, end_time, event_date, location, title, description, event_type, presenters) 
        VALUES ('','','','Rhea Miller Recital Hall','Kingdom Come: Deliver Mail, Mass Destruction','Unmanned aerial vehicles, also known as drones, are the weapon of choice in modern warfare. Used primarily by the United States to combat terrorist sects in the Middle East, recent estimates believe thousands of people have been killed in drone strikes since 2008. New advances from cutting-edge firms in both the public and private sector are allowing drones to become smaller and smarter than ever. Termed Nano-UAVs, palm-sized drones are the subject of research and development programs offering countless new applications. Unique to Nano-UAVs compared to other drone technologies is that they are small enough to be biomimetic – or modeled to appear and act exactly like living animals. With this in mind, the Defense Advanced Research Projects Agency, or DARPA, is developing programs to allow Nano-UAVs to be autonomous, navigate using mathematical algorithms, and band together in swarms to accomplish large tasks. With such capabilities, Nano-UAVs have the potential to be used as anything from power grid inspection systems to weapons of mass destruction. This ten-minute informative speech utilizes creative language to discuss Nano-UAVs, their advances, and their applications. It has been awarded first place in informative speaking at the Michigan Intercollegiate Speech League (MISL) Novice State Tournament (February, 2015) as well as second place at the MISL Mini Tournament (September, 2015) and MISL Fall Championship (December, 2015).','performance','Erik Breidinger with Dr. Amy Pierce')";
    $performance3 = "
        INSERT INTO ugrp_events (start_time, end_time, event_date, location, title, description, event_type, presenters) 
        VALUES ('','','','Rhea Miller Recital Hall','Hey Mom! Is Orange Really the New Black?','The United Nations document known as “The Bangkok Rules” states that disciplinary sanctions against women prisoners shall not include a prohibition of family contact, especially with children. However, this practice has become routine in the United States. In 1997, the federal government passed the Safe Families and Adoption Act, which mandates that state agencies file a petition for the termination of parental rights when a child has been in foster care for more than 15 of the most recent 22 months. For single mothers who are incarcerated this means never getting to know a child born in prison or potentially losing custody of older children when other family members are unable to care for them. These circumstances prompted the World’s Children’s Prize Foundation in 2004 to identify parental incarceration as the “greatest threat to child well-being in the US.” This mixed-media performance combines the children’s book, Harry Sue by Sue Stauffacher, the personal narrative “Pregnancy in Prison” by Kebby Warner, and the “In These Times Magazine” feature article “US prisons and jails are threatening the lives of pregnant women and their babies” by Victoria Law to argue that it is time to reconsider the policies regarding maternal incarceration. This programmed oral interpretation was awarded first place at the Michigan Intercollegiate Speech League (MISL) Fall Tournament (December, 2015) and second place (Top Novice) at the MISL State tournament in March, 2016.','performance','Gina Kearly, Dr. Amy Pierce')";
    
    // SCHEDULE
    $schedule1 = "
        INSERT INTO ugrp_events (start_time, end_time, event_date, location, title, description, event_type, presenters) 
        VALUES ('1:00:00','1:15:00','2010-7-10','Groening Commons','Event Welcome','','schedule','')";
    $schedule2 = "
        INSERT INTO ugrp_events (start_time, end_time, event_date, location, title, description, event_type, presenters) 
        VALUES ('2:00:00','3:00:00','2010-7-10','Seminar D','Paper Presentations 1','\"The Role of Play in Supporting Mathematical Understanding in Kindergarten \" Jazmyne Jacobs, Dr. Colleen D\'Arcy<br /><br />\"The Effect of Short-term Study Abroad Experience on Students\' Leadership Skills and Career Aspirations\" Alexis Geyer, Jenni Putz, Dr. Kaustav Misra<br /><br />\"Utilizing Board Games in the Teaching of International Politics\" Taylor Pierson, Agnes Simon<br /><br />\"A Study of Writing Center Tutors\' Perceptions of their ESL Peers\" Alison Barger, Dr. Veronika Drake','schedule','')";
    $schedule3 = "
        INSERT INTO ugrp_events (start_time, end_time, event_date, location, title, description, event_type, presenters) 
        VALUES ('2:00:00','3:00:00','2010-7-10','Seminar E','Paper Presentations 2','\"Associations Between Dietary Behaviors And Objectively Measured Physical Activity Behaviors\" Graceson C. Kerr, Meghan Baruth, Rebecca A. Schlaff<br /><br />\"A Crown of Thorns: African American Women\'s Oppression through Patriarchal Protection\" Ciera Casteel, Dr. Kenneth Jolly<br /><br />\"US Foreign Aid and Human Rights Records of Recipient Countries\" Brian Fox, Dr. Stewart French<br /><br />\"Indulgence, Restraint, and Within Country Diversity: Exploring Entrepreneurial Outcomes with New Constructs\" Heidi Hicks, Zack Gibson, Dr. George Puia','schedule','')";
    $schedule4 = "
        INSERT INTO ugrp_events (start_time, end_time, event_date, location, title, description, event_type, presenters) 
        VALUES ('3:00:00','4:00:00','2010-7-10','G6','Virtual Reality Demonstrations','','schedule','')";
    $schedule5 = "
        INSERT INTO ugrp_events (start_time, end_time, event_date, location, title, description, event_type, presenters) 
        VALUES ('1:00:00','1:15:00','2010-10-10','Groening Commons','Event Welcome','','schedule','')";
    $schedule6 = "
        INSERT INTO ugrp_events (start_time, end_time, event_date, location, title, description, event_type, presenters)
        VALUES ('2:00:00','3:00:00','2010-10-10','C102','Paper Presentation 3','\"Influence of Parental Characteristics on Time Spent Being Active with their Children\" Melissa Jones, Dr. Meghan Baruth, Dr. Rebecca A. Schlaff, Dr. Joshua J. Ode, Dr. David M. Callejo<br /><br />\"Growth Investment Strategies Generating Risk-Adjusted Returns\" Juan Sancen, Curtis Grosse<br /><br />\"University Strategies Targeting CPA Diversity\" Beatrice Yarney, Dr. Elizabeth Pierce<br /><br />\"Examining the Relationships Among Celebratory Context, Interaction Goals, and Message Production\" Elizabeth England, Dr. Jennifer McCullough','schedule','')";
    $schedule7 = "
        INSERT INTO ugrp_events (start_time, end_time, event_date, location, title, description, event_type, presenters) 
        VALUES ('2:00:00','3:00:00','2010-10-10','Rhea Miller Recital Hall','Performances','\"Metal Coils and Chronic Conditions: The Reality of Essure\" Melinda Dinninger, Dr. Amy Pierce<br /><br />\"Kingdom Come: Deliver Mail, Mass Destruction\" Erik Breidinger, Dr. Amy Pierce<br /><br />\"Hey Mom! Is Orange Really the New Black?\" Gina Kearly, Dr. Amy Pierce','schedule','')";
    $schedule8 = "
        INSERT INTO ugrp_events (start_time, end_time, event_date, location, title, description, event_type, presenters) 
        VALUES ('3:00:00','4:00:00','2010-10-10','Rhea Miller Recital Hall','Closing Remarks','','schedule','')";

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->query($poster1);
    $pdo->query($poster2);
    $pdo->query($poster3);
    $pdo->query($paper1);
    $pdo->query($paper2);
    $pdo->query($paper3);
    $pdo->query($performance1);
    $pdo->query($performance2);
    $pdo->query($performance3);
    $pdo->query($schedule1);
    $pdo->query($schedule2);
    $pdo->query($schedule3);
    $pdo->query($schedule4);
    $pdo->query($schedule5);
    $pdo->query($schedule6);
    $pdo->query($schedule7);
    $pdo->query($schedule8);
    Database::disconnect();
}

// EMPTY TABLE
function emptyTable() {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->query("DELETE FROM ugrp_events");
    Database::disconnect();
}

// DROP TABLE
function dropTable() {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->query("DROP TABLE ugrp_events");
    Database::disconnect();
}

// CALL FUNCTIONS
// dropTable();
// createTable();
// emptyTable();
// populateTable();

// DONE
echo "done";
?>
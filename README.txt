Mike Moschella
Ross Hall
DB 2
Phase 2
3/27/19

To Install Software:

- Make sure XAMPP is running on your computer
    and that you have started apache and mysql
    using the control panel.

- Store project in htdocs folder

- Make sure you can access mysql using the command 
    line and use the following commands to set up
    the database:

    - mysql -u root
    - GRANT ALL PRIVILEGES ON *.* TO root@Localhost
    - CREATE DATABASE DB2;
    - USE DB2;
    - source C:\xampp\htdocs\DB2\sql\create_tables.sql

- In web browser navigate to http://localhost/db2-practice/Phase2.html

*************************************************************************
Notes: 

- All 8 of the tasks in the assignment description have been 
implemented, however often several different queries are used
in completing a given task. 

- We implemented the project in a style similar to the TA, We used
lots of different php files for various tasks and most of the html 
is embedded in those php files.

- Notifications for students and parents are displayed on their
dashboard and not listed in separate files. When a user logs
into their dashboard a check is made to see if they have any 
notifications that need to be displayed. We were told that this
was acceptable by both the TA and Professor Chen. 

- If a query was made but there is no information (ex. A student is
not enrolled in any sections) sometimes this is indicated in the GUI,
however sometimes a blank table is displayed.

- Some extra features we implemented are the ability for students to 
view a list of moderators and their contact information. The ability 
for Moderators to view a list of all students and their parents as well
as their contact information. A review system where mentees can write
reviews for mentors that they recently studied with. These reviews must
be verified by the moderator of the section that the mentee and mentor were
enrolled in. When a review needs to be verified it is displayed in the
notification system on the moderators dashboard. Once verified all students
can see the reviews for all mentors. 

I believe the tables are set up to have some notifications displaying
for most of April.

You can log in as becky the moderator to see notifications for assigning mentors:
email = becky@becky.com
password = password

You can log in as bart the student to se notifications for canceled sessions:
email = bart@bart.com
password = password

You can log in as brock to write lots of reviews that becky can verify:
email = brock@brock.com
password = password




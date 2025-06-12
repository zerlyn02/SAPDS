# SAPDS
 Ho Kai Ying 293256 FYP Student Arrival and Pickup Detection System

This is a attendance system for primary/secondary school students, framework used:
- AWS EC2 (hosting)
- AWS RDS, SQL workbench (database)
- Firebase Cloud Messaging (notification)
- Arduino (RFID)
- TCPDF (generate attendance PDF)
- PHP Mailer (forgot password)

# Role of users involved:
- School administrator
    - Clerk
        - Register student/user
        - Read RFID tag
        - Read student list (CRUD)
        - Class timetable/ teaching schedule (CRUD)
        - Review student location
        - Review/ add student attendance & generate attendance PDF
    
    - Teacher
        - Review/ add student attendance
        - Review student location
        - Review teaching schedule/ class timetable & generate attendance PDF
    
- Guardian
    - Review child's attendance & generate attendance PDF
    - Review child's location
    - Review child's class's timetable

# What does the system do:
- RFID reader shall be installed at school gate and classes, when student arrive at school or enter/exit any classroom, they shall scan the RFID tag on them.
- System will read and record student's attendance and location at the same time.
- Guardian will recieve notification if they install in phone as their child went in or out any location and a pick up notification when their child is ready to be picked up at the gate.
- School administrator will recieve notification for every student for location updates.
- School administrator can add manual attendance upon exception cases.
- Clerk will register and check the RFID tag of students' before handling to students.
- Clerk can CRUD student details at student list.
- Clerk will get to CRUD class timetable with teaching teacher, it will be updated for class timetable and teacher's teaching schedule.
- All users can check on the attendance and generate relavent attendance PDF.

# Link access to website:
http://18.141.9.202/sapds/src/index.html

# Coding file located at:
ec2-user>sapds>src

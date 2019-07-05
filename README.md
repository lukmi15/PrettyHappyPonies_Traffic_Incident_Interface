#PrettyHappyPonies_Traffic_Incident_Interface

This is a project that has taken place at HTW Berlin in summer semester 2019. The project was part of the seminar "Project Software Development" from the course of study Computer Engineering.

In case anybody wonders ... PrettyHappyPonies was the name of our team. 😅

##Back story

A team of students was to visualize data from a MongoDB instance that features traffic incident data of Berlin and other German cities. Only the data from Berlin was to be visualized.
We implemented a map that shows the physical location of those incidents and more information when the map marker was clicked on.
Additionally, a heat map was implemented.
For the map data and visualization, we used the Google Maps API.

##Running the website

In order to run this webpage, you need a web server and a PHP server. Before the website will work, the backend PHP script will have to be executed at least once. You may execute it to refresh the data at any time.

##Limitations

We are not loading all the data from the database because the web server was running on a Raspberry Pi 3b and we did not have enough time to increase performance.

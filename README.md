Introduction
This document outlines the development of a dashboard using PHP Laravel, incorporating service request statistics, user reports, and user analytics. The dashboard provides visual representations of data through tables and charts, making it easier for administrators to monitor system activities effectively.
Controller: DashboardController
The DashboardController retrieves and processes data from different models before passing it to the view for display.
Key Functionalities:
Service Requests:


Total Requests
Pending Requests
Approved Requests
Rejected Requests
User Reports:


Total Reports
Pending Reports
Reviewed Reports
Rejected Reports
Users:


Total Users
New Users in the Current Month
User Login Trends (Last 30 days)

Dashboard Layout
The dashboard uses AdminLTE for UI styling and Chart.js for visual representation.
Key Components:
Statistics Boxes: Display key metrics.
Pie Chart: Shows the status of service requests.
Line Chart: Represents user logins over time.

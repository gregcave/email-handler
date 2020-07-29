# travotic
A simple Laravel app that generates a set message from a series of responses based on a user's email correspondence

## Project Overview
This project consists of a simple Laravel web application that generates a series of responses based on an email sent by a user.

The application consists of a set of commands, that run every minute to check an email inbox for any unread emails that match a set criteria as defined in the project scope.

If an email message is found, it is marked as being seen (to avoid any duplicate email messages), and the relevant email it sent to the user with a message matching the criteria.

### File Overview
* **/app/Console/Commands**: Contains all of the relevant commands relating to the email messages.
* **/app/Console/Kernel.php**: Calls each of the commands every minute to check the inbox for unread messages.
* **/resources/views/email.twig**: The template file used to generate the email response.
* **/app/Mail**: Defines the logic for each of the email messages that can be sent to a user.

## Project Scope
The project scope relating to this task is minimal, as defined in the brief, a simple ‘middleware-style service’ could be used to parse incoming emails and extract key words. In order to define the functionality and allow for the set criteria to be fully met, a series of user stories could be used.

### User Stories
* As a customer, I want to be able to inform Travotic that I haven’t received my booking conformation, so that I can receive a response containing the Booking confirmation.
* As a customer, I want to be able to confirm with Travotic that I can cancel my booking without any charge, so that I can be made aware of the company policy.
* As a customer, I want to be able to receive confirmation from Travotic when I inform them that I’d like to change the booking dates, so that I can be made aware of any human intervention that may be required to modify the booking.

## Approach to the Solution
In order to develop a solution that effectively meets the set criteria, I have decided to build a simple Laravel application, that uses task scheduling (https://laravel.com/docs/7.x/scheduling) with a CRON job, to read any incoming emails, and then generate an appropriate response.

After carrying out some research, I was able to identify that I would need to make use of an IMAP Library for Laravel (https://github.com/Webklex/laravel-imap), in order to retrieve email messages from an AWS WorkMail inbox.

I decided to host this website on my personal AWS account, which is being run by an EC2 Instance (https://aws.amazon.com/ec2/) that I setup using a pre-made image copied from a similar project.

To host the code, I setup a GitHub repository (https://github.com/gregcave/travotic) that contains the entire Laravel application. The EC2 instance being used will automatically pull the latest version of this repo onto the instance each time a commit is made.

Lastly, an AWS WorkMail account was provisioned with the email ‘test.account@gregcave.com’ that will be used to host the Mailbox and provide the application with access to all email messages.

### Rationale
I chose to develop this solution using Laravel, as I already have experience using the framework to generate email responses from another project that I’ve worked on. I identified that the quickest way to get the web application running would be to make a copy of an existing project, which is why I chose to host the project on my personal AWS account.

I setup the GitHub repository as I already have a number of projects hosted with this website, and I wanted an easy way to showcase the code that I’ve made, as well as a fast way to pull updates onto the EC2 instance that was provisioned. The AWS WorkMail account was setup as this was the easiest way for me to get an account up and running, and this was what was specified in the project brief.

## Limitations
The solution that has been developed does contain a number of limitations:

* The user is required to input an exact phrase, such as “I would like to change my booking dates”, the solution will currently not except a different phrase such as “I’d like to change my booking dates” or “I would like to modify my booking dates”.
* There is no functionality for a staff member at Travotic to be informed when human intervention is required, such as when a customer wants to change their booking dates.
* There is no way for staff members at Travotic to track and make updates to customer enquiries, ideally this would be done with the use of a ticket-based system, where both staff members and customers can add comments, take actions on the ticket and more.

## Scalability
In order to properly scale out this solution, I would address the limitations addressed above. Furthermore, instead of running the application using task scheduling (every minute), I would implement a webhook (https://laravel-news.com/laravel-inbound-email), that responds to the any email messages almost instantly.

I would also implement a form of auto-scaling (https://aws.amazon.com/autoscaling/) to ensure that the component does not fail, as well as a database system that could be used to record and track all email messages.

### PoC Stages / Live Environment
As previously mentioned, if this solution was to be deployed on a live environment, a ticket-based system should be implemented that would be used to track all data and provide both customers and staff members with the ability to respond and close the ticket.

I would also expand the functionality of the decision engine to generate and send the correct response to a variety of customer messages, and also implement functionality that provides a generic message to the customers, which contain a set of responses that a customer is able to choose from.

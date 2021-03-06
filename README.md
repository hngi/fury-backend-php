#  Employee Planner microserve (Laravel PHP Framework)
# fury-backend-php
Repository for employee calendar micro-service

## Problem
The team intend to have an application that can manage scheduling of meeting or task for organizarion.

## Description
The planner micro-serive is a meeting/task mangement scheduling micro-service for organizations.

## User Classes
There will be two categories of users, the admin and the attendant(employee)
* Administrator
* Employee

## Features
* Event is setup by an administrator
* Authentication is required to grant access to employees
* Employee gets notification in their dashboard

## Validation
Validation is done using laravel validator

## Meeting Endpoint
* Create meeting with attendants
* Update meeting properties including time and attendant
* Delete a meeting
* Get all meeting
* Get a particular meeting 

## FlowChart & E-R Diagram
![](ER-Diagram.png)

## DB Structure
Meetings table
* meeting_id
* name
* email
* password
* event_id
* user_id
* timestamps

Meeting_participants table
* event_id
* employee_id
* user_id
* timestamps

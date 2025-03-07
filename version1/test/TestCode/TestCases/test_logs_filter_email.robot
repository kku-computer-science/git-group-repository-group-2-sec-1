*** Settings ***
Documentation  Test cases for logs filter by email
Library      SeleniumLibrary
Resource  ../resources/common_resource.robot
Resource  ../resources/logs_resource.robot
Suite Setup     Open Website
Suite Teardown  SeleniumLibrary.Close Browser

*** Test Cases ***
TC1: Admin login
    [Documentation]    Admin login
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Page Should Contain  Logs System

TC2: Admin login and accesses logs
    [Documentation]    Admin accesses logs page
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Link  Logs System
    Wait Until Page Contains  System Logs

TC3: Filter logs by email (Exist Email)
    [Documentation]    Filter logs by email (Exist Email)
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Link  Logs System
    Wait Until Page Contains  System Logs
    Filter Logs by Email  example@example.com
    Wait Until Page Contains  Logs for example@example.com

TC4: Filter logs by email (Non-Exist Email)
    [Documentation]    Filter logs by email (Non-Exist Email)
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Link  Logs System
    Wait Until Page Contains  System Logs
    Filter Logs by Email  nonexist@example.com
    Wait Until Page Contains  No records found
*** Settings ***
Documentation  Test cases for logs detail
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

TC3: Admin verify logs info
    [Documentation]    Admin verify logs info
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Link  Logs System
    Wait Until Page Contains  System Logs
    Logs Info

TC4: Admin verify user info
    [Documentation]    Admin verify user info
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Link  Logs System
    Wait Until Page Contains  System Logs
    User Info

TC5: Admin verify activity status
    [Documentation]    Admin verify activity status
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Link  Logs System
    Wait Until Page Contains  System Logs
    Activity Status
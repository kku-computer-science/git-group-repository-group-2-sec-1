*** Settings ***
Documentation    Test cases for logs access
Library      SeleniumLibrary
Resource  ../resources/common_resource.robot
Resource  ../resources/logs_resource.robot
Suite Setup      Open Website
Suite Teardown   Close Browser
Test Setup       Go To Login Page
Test Teardown    Log Out

*** Test Cases ***

TC1: User login
    [Documentation]    User login
    Go To Login Page
    Login as User
    Wait Until Page Contains  Dashboard
    Page Should Not Contain  Logs System

TC2: User tries to access logs page
    [Documentation]    User tries to access logs page
    Go To Login Page
    Login as User
    Go To  ${URL}/logs
    Wait Until Page Contains  Dashboard
    Page Should Not Contain  Logs System

TC3: Admin login
    [Documentation]    Admin login
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard

TC4: Admin accesses logs page
    [Documentation]    Admin accesses logs page
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Element    xpath=//*[@id="sidebar"]/ul/li[12]/a
    Wait Until Page Contains  System Logs

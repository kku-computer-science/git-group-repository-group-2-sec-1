*** Settings ***
Documentation  Test cases for logs filter by activity type
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

TC3: Filter logs by activity type (Allactivity)
    [Documentation]    Filter logs by activity type (All activity)
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Link  Logs System
    Wait Until Page Contains  System Logs
    Filter Logs by Activity Type  All activity
    Wait Until Page Contains  All activity Logs

TC4: Filter logs by activity type (Login)
    [Documentation]    Filter logs by activity type (Login)
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Link  Logs System
    Wait Until Page Contains  System Logs
    Filter Logs by Activity Type  Login
    Wait Until Page Contains  Login Logs

TC5: Filter logs by activity type (Logout)
    [Documentation]    Filter logs by activity type (Logout)
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Link  Logs System
    Wait Until Page Contains  System Logs
    Filter Logs by Activity Type  Logout
    Wait Until Page Contains  Logout Logs

TC6: Filter logs by activity type (Error)
    [Documentation]    Filter logs by activity type (Error)
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Link  Logs System
    Wait Until Page Contains  System Logs
    Filter Logs by Activity Type  Error
    Wait Until Page Contains  Error Logs

TC7: Filter logs by activity type (Add Data)
    [Documentation]    Filter logs by activity type (Add Data)
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Link  Logs System
    Wait Until Page Contains  System Logs
    Filter Logs by Activity Type  Add Data
    Wait Until Page Contains  Add Data Logs

TC8: Filter logs by activity type (Update Data)
    [Documentation]    Filter logs by activity type (Update Data)
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Link  Logs System
    Wait Until Page Contains  System Logs
    Filter Logs by Activity Type  Update Data
    Wait Until Page Contains  Update Data Logs

TC9: Filter logs by activity type (Delete Data)
    [Documentation]    Filter logs by activity type (Delete Data)
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Link  Logs System
    Wait Until Page Contains  System Logs
    Filter Logs by Activity Type  Delete Data
    Wait Until Page Contains  Delete Data Logs
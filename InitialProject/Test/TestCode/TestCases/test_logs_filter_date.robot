*** Settings ***
Documentation  Test cases for logs filter by date
Resource  ../resources/common_resource.robot
Resource  ../resources/logs_resource.robot
Suite Setup     Open Website
Suite Teardown  Close Website

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

TC3: Filter logs by a specific date
    [Documentation]    Filter logs by a specific date
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Link  Logs System
    Wait Until Page Contains  System Logs
    Filter Logs by Date  02/08/2025
    Wait Until Page Contains  Logs for 02/08/2025

TC4: Filter logs by date range
    [Documentation]    Filter logs by date range
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Link  Logs System
    Wait Until Page Contains  System Logs
    Filter Logs by Date  01/08/2025 - 02/08/2025
    Wait Until Page Contains  Logs from 01/08/2025 to 02/08/2025

TC5: Filter logs when no records exist
    [Documentation]    Filter logs when no records exist
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Link  Logs System
    Wait Until Page Contains  System Logs
    Filter Logs by Date  01/01/2024
    Wait Until Page Contains  No records found
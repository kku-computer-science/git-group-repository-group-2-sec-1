*** Settings ***
Documentation  Test cases for logs filter by date
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

TC2: Admin login and accesses logs
    [Documentation]    Admin accesses logs page
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Element    xpath=//*[@id="sidebar"]/ul/li[12]/a
    Wait Until Page Contains  System Logs

TC3: Filter logs by a specific date
    [Documentation]    Filter logs by a specific date
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Element    xpath=//*[@id="sidebar"]/ul/li[12]/a
    Wait Until Page Contains  System Logs
    Filter Logs by Date  02/11/2025
    Wait Until Page Contains  2025/02/11

TC4: Filter logs by date range
    [Documentation]    Filter logs by date range
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Element    xpath=//*[@id="sidebar"]/ul/li[12]/a
    Wait Until Page Contains  System Logs
    Filter Logs by Date  02/10/2025 - 02/11/2025
    Wait Until Page Contains  Logs from 2025/02/10 to 2025/02/11

TC5: Filter logs when no records exist
    [Documentation]    Filter logs when no records exist
    Go To Login Page
    Login as Admin
    Wait Until Page Contains  Dashboard
    Click Element    xpath=//*[@id="sidebar"]/ul/li[12]/a
    Wait Until Page Contains  System Logs
    Run Keyword And Continue On Failure  Wait Until Page Contains  No records found
    Page Should Contain  No records found
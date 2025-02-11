*** Settings ***
Library  SeleniumLibrary

*** Variables ***
${URL}  http://cs0267.cpkkuhost.com
${BROWSER}  Chrome
${ADMIN_USER}  admin@gmail.com
${ADMIN_PASS}  12345678
${USER_EMAIL}  ngamnij@kku.ac.th
${USER_PASS}   123456789
${DELAY}       0.2

*** Keywords ***
Open Website
    Open Browser  ${URL}  ${BROWSER}
    Maximize Browser Window

Go To Main Page
    Go To  ${URL}

Open System Logs Page
    Go To  ${URL}/logs
    Wait Until Page Contains  System Logs

Go To Login Page
    Go To  ${URL}/login
    Wait Until Page Contains  Login
    
Close Website
    Close Browser

Login as Admin
    Input Text  id=username  ${ADMIN_USER}
    Input Text  id=password  ${ADMIN_PASS}
    Click Button  xpath=//button[contains(text(), 'Log In')]
    Wait Until Page Contains  Dashboard

Login as User
    Input Text  id=username  ${USER_EMAIL}
    Input Text  id=password  ${USER_PASS}
    Click Button  xpath=//button[contains(text(), 'Log In')]
    Wait Until Page Contains  Dashboard

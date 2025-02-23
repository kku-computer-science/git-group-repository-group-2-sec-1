*** Settings ***
Documentation    Test the language switching functionality
Resource  ../resources/common_resource.robot
Resource  ../resources/logs_resource.robot
Resource  ../resources/language_resource.robot
Test Setup  Open Website
Test Teardown  Close Website

*** Test Cases ***
TC1: Verify Default Language
    [Documentation]  Verify that the website defaults to English when first opened
    Go To Main Page
    Verify Page Language  HOME  

TC2: Switch to Thai and Verify
    [Documentation]  Switch to Thai and verify the language change
    Go To Main Page
    Switch to Thai
    Verify Page Language  หน้าแรก  

TC3: Switch to Thai and Refresh
    [Documentation]  Switch to Thai, refresh, and verify the language persists
    Go To Main Page
    Switch to Thai
    Refresh Page
    Verify Page Language  หน้าแรก

TC4: Switch to English and Verify
    [Documentation]  Switch to English and verify the language change
    Go To Main Page
    Switch to Thai
    Switch to English
    Verify Page Language  HOME

TC5: Switch to English and Refresh
    [Documentation]  Switch to English, refresh, and verify the language persists
    Go To Main Page
    Switch to Thai
    Switch to English
    Refresh Page
    Verify Page Language  HOME
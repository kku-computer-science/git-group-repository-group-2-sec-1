*** Settings ***
Documentation    Test cases for logs dashboard and page
Library    SeleniumLibrary
Resource  ../resources/common_resource.robot
Resource  ../resources/logs_resource.robot
Suite Setup      Open Website
Suite Teardown   SeleniumLibrary.Close Browser
Test Setup       Go To Login Page
Test Teardown    Log Out

*** Test Cases ***

TC1: Admin Login
    [Documentation]    ทดสอบการเข้าสู่ระบบของ Admin
    Login as Admin
    Wait Until Page Contains    Dashboard    timeout=10s

TC2: Admin เข้าถึง Logs Dashboard
    [Documentation]    ตรวจสอบ Dashboard Logs
    Login as Admin
    Wait Until Page Contains    Dashboard    timeout=10s

TC3: Admin ตรวจสอบการแสดงจำนวนผู้ใช้
    [Documentation]    ตรวจสอบว่ามีจำนวนผู้ใช้ทั้งหมดแสดงใน Dashboard
    Login as Admin
    Wait Until Page Contains    จำนวนผู้ใช้ทั้งหมด   timeout=10s
    Click Element   xpath=/html/body/div/div/div/div/div/div[2]/div[1]/a/div
    Show User Page

TC4: Admin ตรวจสอบการแสดงจำนวนงานวิจัย
    [Documentation]    ตรวจสอบว่ามีจำนวนงานวิจัยแสดงใน Dashboard
    Login as Admin
    Wait Until Page Contains    จำนวนงานวิจัยทั้งหมด    timeout=10s
    Click Element   xpath=/html/body/div/div/div/div/div/div[2]/div[2]/a/div
    Show Research Page

TC5: Admin ตรวจสอบจำนวนผู้เข้าสู่ระบบ
    [Documentation]    ตรวจสอบจำนวนผู้เข้าสู่ระบบใน Dashboard
    Login as Admin
    Wait Until Page Contains    จำนวนครั้งการเข้าสู่ระบบในวันนี้    timeout=10s
    Click Element   xpath=/html/body/div/div/div/div/div/div[2]/div[3]/a/div
    Show Login Logs Page

TC6: Admin ตรวจสอบจำนวนการเรียก API
    [Documentation]    ตรวจสอบจำนวนการเรียก API วันนี้
    Login as Admin
    Wait Until Page Contains    จำนวนการเรียก API ในวันนี้    timeout=10s
    Click Element   xpath=/html/body/div/div/div/div/div/div[2]/div[4]/a
    Show API Logs Page

TC7: Admin ตรวจสอบการแสดง Error Document
    [Documentation]    ตรวจสอบการแสดง Error Document
    Login as Admin
    Scroll Element Into View    xpath=/html/body/div/div/div/div/div/div[4]/div/div/div/div[1]/a
    Click Element    xpath=/html/body/div/div/div/div/div/div[4]/div/div/div/div[1]/a
    Show Error Document Page

TC8: Admin ตรวจสอบ Error Login
    [Documentation]    ตรวจสอบ Error Login
    Login as Admin
    Scroll Element Into View    xpath=/html/body/div/div/div/div/div/div[3]/div/div/div/div[2]/div[2]
    Click Element    xpath=/html/body/div/div/div/div/div/div[3]/div/div/div/div[2]/div[2]
    Show Error Login Page

TC9: Admin ตรวจสอบ Error API
    [Documentation]    ตรวจสอบ Error API
    Login as Admin
    Scroll Element Into View    xpath=/html/body/div/div/div/div/div/div[3]/div/div/div/div[2]/div[1]
    Click Element    xpath=/html/body/div/div/div/div/div/div[3]/div/div/div/div[2]/div[1]
    Show Error API Page
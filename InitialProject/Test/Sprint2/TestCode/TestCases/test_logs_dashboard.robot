*** Settings ***
Documentation    Test cases for logs dashboard
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

TC3: Admin เข้าถึง Logs Dashboard และเปิด Full Log
    [Documentation]    ตรวจสอบการเปิดหน้า System Logs
    Login as Admin
    Click Element    xpath=/html/body/div/div/div/div/div/div[1]/div[2]/div[2]/button[2]
    Wait Until Page Contains    System Logs    timeout=10s

TC4: Admin ตรวจสอบการแสดงจำนวนผู้ใช้
    [Documentation]    ตรวจสอบว่ามีจำนวนผู้ใช้ทั้งหมดแสดงใน Dashboard
    Login as Admin
    Wait Until Page Contains    จำนวนผู้ใช้ทั้งหมด   timeout=10s

TC5: Admin ตรวจสอบการแสดงจำนวนงานวิจัย
    [Documentation]    ตรวจสอบว่ามีจำนวนงานวิจัยแสดงใน Dashboard
    Login as Admin
    Wait Until Page Contains    จำนวนงานวิจัยทั้งหมด    timeout=10s

TC6: Admin ตรวจสอบจำนวนผู้เข้าสู่ระบบ
    [Documentation]    ตรวจสอบจำนวนผู้เข้าสู่ระบบใน Dashboard
    Login as Admin
    Wait Until Page Contains    จำนวนครั้งการเข้าสู่ระบบในวันนี้    timeout=10s

TC7: Admin ตรวจสอบจำนวนการเรียก API
    [Documentation]    ตรวจสอบจำนวนการเรียก API วันนี้
    Login as Admin
    Wait Until Page Contains    จำนวนการเรียก API ในวันนี้    timeout=10s
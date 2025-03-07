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
TC1: User Login ไม่ถูกต้อง
    [Documentation]    ทดสอบการล็อกอินไม่ถูกต้องเกิน 5 ครั้งและตรวจสอบ Dashboard
    FOR    ${i}    IN RANGE    6
        Login Fail as User
    END
    Login as Admin
    Wait Until Page Contains    Dashboard    timeout=10s
    Scroll Element Into View    xpath=//a[contains(., 'การล็อกอินผิดพลาดหลายครั้ง')]
    Wait Until Element Is Visible    xpath=//a[contains(., 'การล็อกอินผิดพลาดหลายครั้ง')]   timeout=10s
    # เลือกลิงก์ที่มีเวลาล่าสุด
    Click Element    xpath=(//a[contains(., 'การล็อกอินผิดพลาดหลายครั้ง')])[1]
    Show Error Login Page

TC2: User Call Papers เกิน 5 ครั้ง
    [Documentation]    ทดสอบการเรียก API เกิน 5 ครั้งและตรวจสอบ Dashboard
    Login as User
    Wait Until Page Contains    Dashboard    timeout=10s
    Click Element    xpath=//*[@id="sidebar"]/ul/li[8]/a/span
    Click Element    xpath=//*[@id="ManagePublications"]/ul/li[1]/a
    FOR    ${i}    IN RANGE    6
        Wait Until Page Contains Element    xpath=//a[contains(text(), 'Call Paper')]    timeout=10s
        Click Element    xpath=//a[contains(text(), 'Call Paper')]
    END
    Log Out
    Login as Admin
    Wait Until Page Contains    Dashboard    timeout=10s
    Scroll Element Into View    xpath=//a[contains(., 'API ถูกเรียกเกินจำนวนที่กำหนด')]
    Wait Until Element Is Visible    xpath=//a[contains(., 'API ถูกเรียกเกินจำนวนที่กำหนด')]   timeout=10s
    # เลือกลิงก์ที่มีเวลาล่าสุด
    Click Element    xpath=(//a[contains(., 'API ถูกเรียกเกินจำนวนที่กำหนด')])[1]
    Show Error API Page


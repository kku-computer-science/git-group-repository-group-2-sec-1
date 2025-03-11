*** Settings ***
Documentation     Test Cases for Export Logs Access
Resource          ../resources/common_resource.robot
Suite Setup       Open Website
Suite Teardown    Close Browser
# Test Setup      Go To Login Page
Library    XML

*** Test Cases ***
TC01: Admin ตรวจสอบการแสดงข้อมูลในหน้า Export Logs
    [Documentation]    ทดสอบการแสดงข้อมูลกิจกรรมทั้งหมดในหน้า Export Logs
    Go To Login Page
    Login as Admin
    Open System Logs Export Page
    Click Button    id=btnGenerateReport
    Wait Until Page Contains    สรุปกิจกรรมทั้งหมด
    Page Should Contain Element    xpath=//h6[contains(., 'Login Success')]
    Page Should Contain Element    xpath=//h6[contains(., 'Login Failed')]    
    Page Should Contain Element    xpath=//h6[contains(., 'Logout')]
    Page Should Contain Element    xpath=//h6[contains(., 'Create')]
    Page Should Contain Element    xpath=//h6[contains(., 'Update')]
    Page Should Contain Element    xpath=//h6[contains(., 'Delete')]
    Page Should Contain Element    xpath=//h6[contains(., 'Error')]
    Page Should Contain Element    xpath=//h6[contains(., 'Call Paper')]

TC02: Admin ตรวจสอบการแสดงข้อมูล Login Success ในหน้า Export Logs
    [Documentation]    ทดสอบการแสดงข้อมูล Login Success
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Click Element   id=activityLoginFail
    Click Element   id=activityLogout
    Click Element   id=activityCreate
    Click Element   id=activityUpdate
    Click Element   id=activityDelete
    Click Element   id=activityError
    Click Element   id=activityCallPaper
    Click Button    id=btnGenerateReport
    Wait Until Page Contains    สรุปกิจกรรมทั้งหมด
    Page Should Contain Element    xpath=//h6[contains(., 'Login Success')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Failed')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Logout')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Create')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Update')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Delete')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Error')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Call Paper')]

TC03: Admin ตรวจสอบการแสดงข้อมูล Login Failed ในหน้า Export Logs
    [Documentation]    ทดสอบการแสดงข้อมูล Login Failed
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Click Element   id=activityLoginSuccess
    Click Element   id=activityLoginFail
    Click Button    id=btnGenerateReport
    Page Should Contain Element    xpath=//h6[contains(., 'Login Failed')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Success')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Logout')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Create')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Update')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Delete')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Error')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Call Paper')]

TC04: Admin ตรวจสอบการแสดงข้อมูล Logout ในหน้า Export Logs
    [Documentation]    ทดสอบการแสดงข้อมูล Logout
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Click Element   id=activityLoginFail
    Click Element   id=activityLogout
    Click Button    id=btnGenerateReport
    Page Should Contain Element    xpath=//h6[contains(., 'Logout')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'LoginSuccess')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'LoginFail')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Create')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Update')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Delete')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Error')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Call Paper')]

TC05: Admin ตรวจสอบการแสดงข้อมูล Create ในหน้า Export Logs
    [Documentation]    ทดสอบการแสดงข้อมูล Create
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Click Element   id=activityLogout
    Click Element   id=activityCreate
    Click Button    id=btnGenerateReport
    Page Should Contain Element    xpath=//h6[contains(., 'Create')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Success')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Failed')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Logout')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Update')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Delete')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Error')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Call Paper')]

TC06: Admin ตรวจสอบการแสดงข้อมูล Update ในหน้า Export Logs
    [Documentation]    ทดสอบการแสดงข้อมูล Update
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Click Element   id=activityCreate
    Click Element   id=activityUpdate
    Click Button    id=btnGenerateReport
    Page Should Contain Element    xpath=//h6[contains(., 'Update')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Success')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Failed')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Logout')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Create')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Delete')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Error')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Call Paper')]

TC07: Admin ตรวจสอบการแสดงข้อมูล Delete ในหน้า Export Logs
    [Documentation]    ทดสอบการแสดงข้อมูล Delete
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Click Element   id=activityUpdate
    Click Element   id=activityDelete
    Click Button    id=btnGenerateReport
    Page Should Contain Element    xpath=//h6[contains(., 'Delete')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Success')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Failed')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Logout')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Create')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Update')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Error')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Call Paper')]


TC08: Admin ตรวจสอบการแสดงข้อมูล Error ในหน้า Export Logs
    [Documentation]    ทดสอบการแสดงข้อมูล Error
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Click Element   id=activityDelete
    Click Element   id=activityError
    Click Button    id=btnGenerateReport
    Page Should Contain Element    xpath=//h6[contains(., 'Error')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Success')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Failed')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Logout')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Create')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Update')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Delete')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Call Paper')]

TC09: Admin ตรวจสอบการแสดงข้อมูล Call Paper ในหน้า Export Logs
    [Documentation]    ทดสอบการแสดงข้อมูล Call Paper
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Click Element   id=activityError
    Click Element   id=activityCallPaper
    Click Button    id=btnGenerateReport
    Page Should Contain Element    xpath=//h6[contains(., 'Call Paper')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Success')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Failed')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Logout')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Create')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Update')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Delete')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Error')]

TC10: Admin ตรวจสอบการแสดงข้อมูลในหน้า Export Logs ตามวันที่ในปัจจุบัน
    [Documentation]    ทดสอบการแสดงข้อมูลในหน้า Export Logs ตามวันที่ปัจจุบัน
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Click Element   id=activityLoginSuccess
    Click Element   id=activityLoginFail
    Click Element   id=activityLogout
    Click Element   id=activityCreate
    Click Element   id=activityUpdate
    Click Element   id=activityDelete
    Click Element   id=activityError
    Input Text      id=dateRangeStart    03112025
    Input Text      id=dateRangeEnd      03112025
    Click Button    id=btnGenerateReport
    Wait Until Page Contains    สรุปกิจกรรมทั้งหมด
    Page Should Contain Element    xpath=//h6[contains(., 'Login Success')]
    Page Should Contain Element    xpath=//h6[contains(., 'Login Failed')]
    Page Should Contain Element    xpath=//h6[contains(., 'Logout')]
    Page Should Contain Element    xpath=//h6[contains(., 'Create')]
    Page Should Contain Element    xpath=//h6[contains(., 'Update')]
    Page Should Contain Element    xpath=//h6[contains(., 'Delete')]
    Page Should Contain Element    xpath=//h6[contains(., 'Error')]
    Page Should Contain Element    xpath=//h6[contains(., 'Call Paper')]
    Scroll Element Into View   xpath=//h5[contains(., 'รายละเอียดกิจกรรมผู้ใช้งาน')]
    Sleep    3s

TC11: Admin ตรวจสอบการแสดงข้อมูลในหน้า Export Logs ตามวันที่ทีย้อนหลัง 7 วัน
    [Documentation]    ทดสอบการแสดงข้อมูลในหน้า Export Logs ตามวันที่ทีย้อนหลัง 7 วัน
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Input Text      id=dateRangeStart    03042025
    Input Text      id=dateRangeEnd      03112025
    Click Button    id=btnGenerateReport
    Wait Until Page Contains    สรุปกิจกรรมทั้งหมด
    Page Should Contain Element    xpath=//h6[contains(., 'Login Success')]
    Page Should Contain Element    xpath=//h6[contains(., 'Login Failed')]
    Page Should Contain Element    xpath=//h6[contains(., 'Logout')]
    Page Should Contain Element    xpath=//h6[contains(., 'Create')]
    Page Should Contain Element    xpath=//h6[contains(., 'Update')]
    Page Should Contain Element    xpath=//h6[contains(., 'Delete')]
    Page Should Contain Element    xpath=//h6[contains(., 'Error')]
    Page Should Contain Element    xpath=//h6[contains(., 'Call Paper')]
    Scroll Element Into View   xpath=//h5[contains(., 'รายละเอียดกิจกรรมผู้ใช้งาน')]
    Sleep    3s

TC12: Admin ตรวจสอบการแสดงข้อมูลในหน้า Export Logs ตามวันที่ทีไม่มีข้อมูล
    [Documentation]    ทดสอบการแสดงข้อมูลในหน้า Export Logs ตามวันที่ที่ไม่มีข้อมูล
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Input Text      id=dateRangeStart    01012025
    Input Text      id=dateRangeEnd      01012025
    Click Button    id=btnGenerateReport
    Handle Alert    ACCEPT
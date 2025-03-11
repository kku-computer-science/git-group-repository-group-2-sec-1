*** Settings ***
Documentation     Test Cases for Checking Validating Show in Export Logs
Resource          ../resources/common_resource.robot
# Suite Setup       Open Website
Suite Teardown    Close Browser
# Test Setup      Go To Login Page
Library           XML

*** Test Cases ***
TC01: Admin ตรวจสอบความถูกต้องสรุปกิจกรรมผู้ใช้งานทั้งหมด
    [Documentation]    ทดสอบการแสดงผลรายละเอียดข้อมูลใน Export Log ว่าสามารถแสดงข้อมูลได้ถูกต้อง
    Open Admin Browser And Login
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

TC02: Admin ตรวจสอบความถูกต้องสรุปกิจกรรม Login Success
    [Documentation]    ทดสอบการแสดงข้อมูล Login Success ว่าสามารถแสดงข้อมูลได้ถูกต้อง
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
    ${before}  Get Text  xpath=//h4[@class='mb-0 fw-bold text-dark']
    Open User Browser And Login
    Close Browser
    Switch Browser    Admin
    Reload Page
    Sleep    3s
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Click Button    id=btnGenerateReport
    Wait Until Page Contains    สรุปกิจกรรมทั้งหมด
    ${after}  Get Text  xpath=//h4[@class='mb-0 fw-bold text-dark']
    Should Not Be Equal  ${before}  ${after}  # ตรวจสอบว่าค่ามีการเปลี่ยนแปลงจริง

TC03: Admin ตรวจสอบความถูกต้องสรุปกิจกรรม Login Failed
    [Documentation]    ทดสอบการแสดงข้อมูล Login Failed ว่าสามารถแสดงข้อมูลได้ถูกต้อง
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Click Element   id=activityLoginSuccess
    Click Element   id=activityLoginFail
    Click Button    id=btnGenerateReport
    Wait Until Page Contains    สรุปกิจกรรมทั้งหมด
    Page Should Contain Element    xpath=//h6[contains(., 'Login Failed')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Success')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Logout')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Create')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Update')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Delete')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Error')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Call Paper')]
    ${before}  Get Text  xpath=//h4[@class='mb-0 fw-bold text-dark']
    Open User Browser And Login Failed
    Close Browser
    Switch Browser    Admin
    Reload Page
    Sleep    3s
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Click Button    id=btnGenerateReport
    Wait Until Page Contains    สรุปกิจกรรมทั้งหมด
    ${after}  Get Text  xpath=//h4[@class='mb-0 fw-bold text-dark']
    Should Not Be Equal  ${before}  ${after}  # ตรวจสอบว่าค่ามีการเปลี่ยนแปลงจริง

TC04: Admin ตรวจสอบความถูกต้องสรุปกิจกรรม Logout
    [Documentation]    ทดสอบการแสดงข้อมูล Logout ว่าสามารถแสดงข้อมูลได้ถูกต้อง
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
    ${before}  Get Text  xpath=//h4[@class='mb-0 fw-bold text-dark']
    Open User Browser And Login
    Log Out
    Close Browser
    Switch Browser    Admin
    Reload Page
    Sleep    3s
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Click Button    id=btnGenerateReport
    Wait Until Page Contains    สรุปกิจกรรมทั้งหมด
    ${after}  Get Text  xpath=//h4[@class='mb-0 fw-bold text-dark']
    Should Not Be Equal  ${before}  ${after}  # ตรวจสอบว่าค่ามีการเปลี่ยนแปลงจริง

TC05: Admin ตรวจสอบความถูกต้องสรุปกิจกรรม Create
    [Documentation]    ทดสอบการแสดงข้อมูล Create ว่าสามารถแสดงข้อมูลได้ถูกต้อง
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
    ${before}  Get Text  xpath=//h4[@class='mb-0 fw-bold text-dark']
    Admin Create New Role
    Open System Logs Export Page
    Click Element   id=activityLoginSuccess
    Click Element   id=activityLoginFail
    Click Element   id=activityLogout
    Click Element   id=activityUpdate
    Click Element   id=activityDelete
    Click Element   id=activityError
    Click Element   id=activityCallPaper
    Click Button    id=btnGenerateReport
    Page Should Contain Element    xpath=//h6[contains(., 'Create')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Success')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Failed')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Logout')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Update')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Delete')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Error')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Call Paper')]
    Wait Until Page Contains    สรุปกิจกรรมทั้งหมด
    ${after}  Get Text  xpath=//h4[@class='mb-0 fw-bold text-dark']
    Should Not Be Equal  ${before}  ${after}  # ตรวจสอบว่าค่ามีการเปลี่ยนแปลงจริง

TC06: Admin ตรวจสอบความถูกต้องสรุปกิจกรรม Update
    [Documentation]    ทดสอบการแสดงข้อมูล Update ว่าสามารถแสดงข้อมูลได้ถูกต้อง
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
    ${before}  Get Text  xpath=//h4[@class='mb-0 fw-bold text-dark']
    Admin Update Role
    Open System Logs Export Page
    Click Element   id=activityLoginSuccess
    Click Element   id=activityLoginFail
    Click Element   id=activityLogout
    Click Element   id=activityCreate
    Click Element   id=activityDelete
    Click Element   id=activityError
    Click Element   id=activityCallPaper
    Click Button    id=btnGenerateReport
    Page Should Contain Element    xpath=//h6[contains(., 'Update')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Success')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Failed')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Logout')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Create')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Delete')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Error')]
    Wait Until Page Contains    สรุปกิจกรรมทั้งหมด
    ${after}  Get Text  xpath=//h4[@class='mb-0 fw-bold text-dark']
    Should Not Be Equal  ${before}  ${after}  # ตรวจสอบว่าค่ามีการเปลี่ยนแปลงจริง

TC07: Admin ตรวจสอบความถูกต้องสรุปกิจกรรม Delete
    [Documentation]    ทดสอบการแสดงข้อมูล Delete ว่าสามารถแสดงข้อมูลได้ถูกต้อง
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
    ${before}  Get Text  xpath=//h4[@class='mb-0 fw-bold text-dark']
    Admin Delete Role
    Open System Logs Export Page
    Click Element   id=activityLoginSuccess
    Click Element   id=activityLoginFail
    Click Element   id=activityLogout
    Click Element   id=activityCreate
    Click Element   id=activityUpdate
    Click Element   id=activityError
    Click Element   id=activityCallPaper
    Click Button    id=btnGenerateReport
    Page Should Contain Element    xpath=//h6[contains(., 'Delete')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Success')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Login Failed')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Logout')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Create')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Update')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Error')]
    Page Should Not Contain Element    xpath=//h6[contains(., 'Call Paper')]
    Wait Until Page Contains    สรุปกิจกรรมทั้งหมด
    ${after}  Get Text  xpath=//h4[@class='mb-0 fw-bold text-dark']
    Should Not Be Equal  ${before}  ${after}  # ตรวจสอบว่าค่ามีการเปลี่ยนแปลงจริง

TC08: Admin ตรวจสอบความถูกต้องสรุปกิจกรรม Error
    [Documentation]    ทดสอบการแสดงข้อมูล Error ว่าสามารถแสดงข้อมูลได้ถูกต้อง
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
    ${before}  Get Text  xpath=//h4[@class='mb-0 fw-bold text-dark']
    Open Error Page
    Switch Browser    Admin
    Reload Page
    Sleep    3s
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Click Button    id=btnGenerateReport
    Wait Until Page Contains    สรุปกิจกรรมทั้งหมด
    ${after}  Get Text  xpath=//h4[@class='mb-0 fw-bold text-dark']
    Should Not Be Equal  ${before}  ${after}  # ตรวจสอบว่าค่ามีการเปลี่ยนแปลงจริง

TC09: Admin ตรวจสอบความถูกต้องสรุปกิจกรรม Call Paper
    [Documentation]    ทดสอบการแสดงข้อมูล Call Paper ว่าสามารถแสดงข้อมูลได้ถูกต้อง
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
    ${before}  Get Text  xpath=//h4[@class='mb-0 fw-bold text-dark']
    Open User Browser And Login
    User Call Paper
    Close Browser
    Switch Browser    Admin
    Reload Page
    Sleep    3s
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Click Button    id=btnGenerateReport
    Wait Until Page Contains    สรุปกิจกรรมทั้งหมด
    ${after}  Get Text  xpath=//h4[@class='mb-0 fw-bold text-dark']
    Should Not Be Equal  ${before}  ${after}  # ตรวจสอบว่าค่ามีการเปลี่ยนแปลงจริง

TC10: Admin ตรวจสอบความถูกต้องสรุป Visitor ในหน้า Export Logs
    [Documentation]    ทดสอบการแสดงข้อมูล Visitor ว่าสามารถแสดงข้อมูลได้ถูกต้อง
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Click Element   id=activityLoginSuccess
    Click Element   id=activityLoginFail
    Click Element   id=activityLogout
    Click Element   id=activityCreate
    Click Element   id=activityUpdate
    Click Element   id=activityDelete
    Click Element   id=activityError
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
    ${before}  Get Text  xpath=//h4[@class='mb-0 fw-bold text-dark']
    Open Website
    Close Browser
    Switch Browser    Admin
    Reload Page
    Sleep    3s
    Scroll Element Into View   xpath=//h5[contains(., 'ตัวกรองรายงาน')]
    Click Button    id=btnGenerateReport
    Wait Until Page Contains    สรุปกิจกรรมทั้งหมด
    ${after}  Get Text  xpath=//h4[@class='mb-0 fw-bold text-dark']
    Should Not Be Equal  ${before}  ${after}  # ตรวจสอบว่าค่ามีการเปลี่ยนแปลงจริง
    
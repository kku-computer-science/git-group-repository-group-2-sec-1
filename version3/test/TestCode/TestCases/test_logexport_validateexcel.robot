*** Settings ***
Documentation     Test Cases for Validate Export Logs Excel
Resource          ../resources/common_resource.robot
Suite Setup       Open Website
Suite Teardown    Close Browser
# Test Setup      Go To Login Page
Library           XML
Library           RPA.Excel.Files

*** Test Cases ***
TC01: Admin ตรวจสอบสรุปกิจกรรมผู้ใช้งานทั้งหมดของ Export Logs แล้วบันทึกเป็นไฟล์ Excel
    [Documentation]    ทดสอบการแสดงสรุปกิจกรรมผู้ใช้งานทั้งหมดในหน้า Export Logs แล้วบันทึกเป็นไฟล์ Excel
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
    Execute JavaScript    window.scrollBy(0, -100);
    Wait Until Page Contains    ส่งออกรายงาน
    Click Button    id=btnExportExcel
    Sleep    10s
    ${latest_excel_file}=  Get Latest File With Prefix    user-activity-report    xlsx
    ${excel_text}=  Get Text From Excel    ${latest_excel_file}    Summary
    Log    ${excel_text}
    Should Contain    ${excel_text}    Login Success
    Should Contain    ${excel_text}    Login Failed
    Should Contain    ${excel_text}    Logout
    Should Contain    ${excel_text}    Create
    Should Contain    ${excel_text}    Update
    Should Contain    ${excel_text}    Delete
    Should Contain    ${excel_text}    Error
    Should Contain    ${excel_text}    Call Paper

TC02: Admin ตรวจสอบสรุปกิจกรรม Login Success ในหน้า Export Logs แล้วบันทึกเป็นไฟล์ Excel
    [Documentation]   ทดสอบการแสดงสรุปกิจกรรม Login Success ในหน้า Export Logs แล้วบันทึกเป็นไฟล์ Excel
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
    Execute JavaScript    window.scrollBy(0, -100);
    Wait Until Page Contains    ส่งออกรายงาน
    Click Button    id=btnExportExcel
    Sleep    10s
    ${latest_excel_file}=  Get Latest File With Prefix    user-activity-report    xlsx
    ${excel_text}=  Get Text From Excel    ${latest_excel_file}    Summary
    Log    ${excel_text}
    Should Contain    ${excel_text}    Login Success
    Should Not Contain    ${excel_text}    Login Failed
    Should Not Contain    ${excel_text}    Logout
    Should Not Contain    ${excel_text}    Create
    Should Not Contain    ${excel_text}    Update
    Should Not Contain    ${excel_text}    Delete
    Should Not Contain    ${excel_text}    Error
    Should Not Contain    ${excel_text}    Call Paper

TC03: Admin ตรวจสอบสรุปกิจกรรม Login Failed ในหน้า Export Logs แล้วบันทึกเป็นไฟล์ Excel
    [Documentation]    ทดสอบการแสดงสรุปกิจกรรม Login Failed ในหน้า Export Logs แล้วบันทึกเป็นไฟล์ Excel
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
    Execute JavaScript    window.scrollBy(0, -100);
    Wait Until Page Contains    ส่งออกรายงาน
    Click Button    id=btnExportExcel
    Sleep    10s
    ${latest_excel_file}=  Get Latest File With Prefix    user-activity-report    xlsx
    ${excel_text}=  Get Text From Excel    ${latest_excel_file}    Summary
    Log    ${excel_text}
    Should Contain    ${excel_text}    Login Failed
    Should Not Contain    ${excel_text}    Login Success
    Should Not Contain    ${excel_text}    Logout
    Should Not Contain    ${excel_text}    Create
    Should Not Contain    ${excel_text}    Update
    Should Not Contain    ${excel_text}    Delete
    Should Not Contain    ${excel_text}    Error
    Should Not Contain    ${excel_text}    Call Paper


TC04: Admin ตรวจสอบสรุปกิจกรรม Logout ในหน้า Export Logs แล้วบันทึกเป็นไฟล์ Excel
    [Documentation]    ทดสอบการแสดงสรุปกิจกรรม Logout ในหน้า Export Logs แล้วบันทึกเป็นไฟล์ Excel
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
    Execute JavaScript    window.scrollBy(0, -100);
    Wait Until Page Contains    ส่งออกรายงาน
    Click Button    id=btnExportExcel
    Sleep    10s
    ${latest_excel_file}=  Get Latest File With Prefix    user-activity-report    xlsx
    ${excel_text}=  Get Text From Excel    ${latest_excel_file}    Summary
    Log    ${excel_text}
    Should Contain    ${excel_text}    Logout
    Should Not Contain    ${excel_text}    LoginSuccess
    Should Not Contain    ${excel_text}    LoginFail
    Should Not Contain    ${excel_text}    Create
    Should Not Contain    ${excel_text}    Update
    Should Not Contain    ${excel_text}    Delete
    Should Not Contain    ${excel_text}    Error
    Should Not Contain    ${excel_text}    Call Paper
    

TC05: Admin ตรวจสอบสรุปกิจกรรม Create ในหน้า Export Logs แล้วบันทึกเป็นไฟล์ Excel
    [Documentation]    ทดสอบการแสดงสรุปกิจกรรม Create ในหน้า Export Logs แล้วบันทึกเป็นไฟล์ Excel
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
    Execute JavaScript    window.scrollBy(0, -100);
    Wait Until Page Contains    ส่งออกรายงาน
    Click Button    id=btnExportExcel
    Sleep    10s
    ${latest_excel_file}=  Get Latest File With Prefix    user-activity-report    xlsx
    ${excel_text}=  Get Text From Excel    ${latest_excel_file}    Summary
    Log    ${excel_text}
    Should Contain    ${excel_text}    Create
    Should Not Contain    ${excel_text}    Login Success
    Should Not Contain    ${excel_text}    Login Failed
    Should Not Contain    ${excel_text}    Logout
    Should Not Contain    ${excel_text}    Update
    Should Not Contain    ${excel_text}    Delete
    Should Not Contain    ${excel_text}    Error
    Should Not Contain    ${excel_text}    Call Paper

TC06: Admin ตรวจสอบสรุปกิจกรรม Update ในหน้า Export Logs แล้วบันทึกเป็นไฟล์ Excel
    [Documentation]    ทดสอบการแสดงสรุปกิจกรรม Update ในหน้า Export Logs แล้วบันทึกเป็นไฟล์ Excel
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
    Execute JavaScript    window.scrollBy(0, -100);
    Wait Until Page Contains    ส่งออกรายงาน
    Click Button    id=btnExportExcel
    Sleep    10s
    ${latest_excel_file}=  Get Latest File With Prefix    user-activity-report    xlsx
    ${excel_text}=  Get Text From Excel    ${latest_excel_file}    Summary
    Log    ${excel_text}
    Should Contain    ${excel_text}    Update
    Should Not Contain    ${excel_text}    Login Success
    Should Not Contain    ${excel_text}    Login Failed
    Should Not Contain    ${excel_text}    Logout
    Should Not Contain    ${excel_text}    Create
    Should Not Contain    ${excel_text}    Delete
    Should Not Contain    ${excel_text}    Error
    Should Not Contain    ${excel_text}    Call Paper

TC07: Admin ตรวจสอบสรุปกิจกรรม Delete ในหน้า Export Logs แล้วบันทึกเป็นไฟล์ Excel
    [Documentation]    ทดสอบการแสดงสรุปกิจกรรม Delete ในหน้า Export Logs แล้วบันทึกเป็นไฟล์ Excel
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
    Execute JavaScript    window.scrollBy(0, -100);
    Wait Until Page Contains    ส่งออกรายงาน
    Click Button    id=btnExportExcel
    Sleep    10s
    ${latest_excel_file}=  Get Latest File With Prefix    user-activity-report    xlsx
    ${excel_text}=  Get Text From Excel    ${latest_excel_file}    Summary
    Log    ${excel_text}
    Should Contain    ${excel_text}    Delete
    Should Not Contain    ${excel_text}    Login Success
    Should Not Contain    ${excel_text}    Login Failed
    Should Not Contain    ${excel_text}    Logout
    Should Not Contain    ${excel_text}    Create
    Should Not Contain    ${excel_text}    Update
    Should Not Contain    ${excel_text}    Error
    Should Not Contain    ${excel_text}    Call Paper

TC08: Admin ตรวจสอบสรุปกิจกรรม Error ในหน้า Export Logs แล้วบันทึกเป็นไฟล์ Excel
    [Documentation]    ทดสอบการแสดงสรุปกิจกรรม Error ในหน้า Export Logs แล้วบันทึกเป็นไฟล์ Excel
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
    Execute JavaScript    window.scrollBy(0, -100);
    Wait Until Page Contains    ส่งออกรายงาน
    Click Button    id=btnExportExcel
    Sleep    10s
    ${latest_excel_file}=  Get Latest File With Prefix    user-activity-report    xlsx
    ${excel_text}=  Get Text From Excel    ${latest_excel_file}    Summary
    Log    ${excel_text}
    Should Contain    ${excel_text}    Error
    Should Not Contain    ${excel_text}    Login Success
    Should Not Contain    ${excel_text}    Login Failed
    Should Not Contain    ${excel_text}    Logout
    Should Not Contain    ${excel_text}    Create
    Should Not Contain    ${excel_text}    Update
    Should Not Contain    ${excel_text}    Delete
    Should Not Contain    ${excel_text}    Call Paper

TC09: Admin ตรวจสอบสรุปกิจกรรม Call Paper ในหน้า Export Logs แล้วบันทึกเป็นไฟล์ Excel
    [Documentation]    ทดสอบการแสดงสรุปกิจกรรม Call Paper ในหน้า Export Logs แล้วบันทึกเป็นไฟล์ Excel
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
    Execute JavaScript    window.scrollBy(0, -100);
    Wait Until Page Contains    ส่งออกรายงาน
    Click Button    id=btnExportExcel
    Sleep    10s
    ${latest_excel_file}=  Get Latest File With Prefix    user-activity-report    xlsx
    ${excel_text}=  Get Text From Excel    ${latest_excel_file}    Summary
    Log    ${excel_text}
    Should Contain    ${excel_text}    Call Paper
    Should Not Contain    ${excel_text}    Login Success
    Should Not Contain    ${excel_text}    Login Failed
    Should Not Contain    ${excel_text}    Logout
    Should Not Contain    ${excel_text}    Create
    Should Not Contain    ${excel_text}    Update
    Should Not Contain    ${excel_text}    Delete
    Should Not Contain    ${excel_text}    Error

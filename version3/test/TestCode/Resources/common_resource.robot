*** Settings ***
Library    SeleniumLibrary
Library    DateTime
Library    OperatingSystem
Library    Process
Library    RequestsLibrary
Library    JSONLibrary
Library    Collections
Library    String
Library    RPA.PDF
Library    RPA.Excel.Files
Library    doc_reader.py


*** Variables ***
${URL}             https://cs02672.cpkkuhost.com
${ADMIN_URL}       https://cs02672.cpkkuhost.com/login
${USER_URL}        https://cs02672.cpkkuhost.com/login
${BROWSER}         Chrome
${ADMIN_BROWSER}   Chrome
${USER_BROWSER}    Firefox
${ADMIN_USER}      admin@gmail.com
${ADMIN_PASS}      12345678
${USER_EMAIL}      ngamnij@kku.ac.th
${USER_PASS}       123456789
${DELAY}           0.3
${DOWNLOAD_PATH}   C:/Users/peton/Downloads/
${TODAY}           ${EMPTY}
${EXPECTED_TEXT}   "รายงานกิจกรรมผู้ใช้งานในระบบ"
${EXPECTED_SHEET1}  Summary
${EXPECTED_SHEET2}  Activity Detail
${EXPECTED_HEADERS}    ['วันที่และเวลา', 'ชื่อผู้ใช้', 'IP Address', 'ประเภทกิจกรรม', 'รายละเอียด', 'อุปกรณ์', 'เบราว์เซอร์']
*** Keywords ***
Open Website
    Open Browser  ${URL}  ${BROWSER}
    Maximize Browser Window
    Set Selenium Speed    ${DELAY}

Go To Main Page
    Go To  ${URL}

Open System Logs Page
    Go To  ${URL}/logs
    Wait Until Page Contains  System Logs

Go To Login Page
    Go To  ${URL}/login
    Wait Until Page Contains  Login
    Set Selenium Speed    ${DELAY}

Log Out
    Click Element    xpath=/html/body/div/nav/div[2]/ul[2]/li[4]/a
    Wait Until Page Contains  Login

Login as Admin
    Input Text  id=username  ${ADMIN_USER}
    Input Text  id=password  ${ADMIN_PASS}
    Click Button  xpath=//button[contains(text(), 'Log In')]
    Wait Until Page Contains  Dashboard
    Set Selenium Speed    ${DELAY}

Open Admin Browser And Login
    Open Browser    ${ADMIN_URL}    ${ADMIN_BROWSER}    alias=Admin
    Maximize Browser Window
    Input Text    id=username    ${ADMIN_USER}
    Input Text    id=password    ${ADMIN_PASS}
    Click Button    xpath=//button[contains(text(), 'Log In')]
    Wait Until Page Contains    Dashboard
    Set Selenium Speed    ${DELAY}

Login as User
    Input Text  id=username  ${USER_EMAIL}
    Input Text  id=password  ${USER_PASS}
    Click Button  xpath=//button[contains(text(), 'Log In')]
    Wait Until Page Contains  Dashboard
    Set Selenium Speed    ${DELAY}

Open User Browser And Login
    Open Browser    ${USER_URL}    ${USER_BROWSER}    alias=User
    Maximize Browser Window
    Switch Browser    User
    Input Text    id=username    ${USER_EMAIL}
    Input Text    id=password    ${USER_PASS}
    Click Button    xpath=//button[contains(text(), 'Log In')]
    Wait Until Page Contains    Dashboard
    Set Selenium Speed    ${DELAY}

Open User Browser And Login Failed
    Open Browser    ${USER_URL}    ${USER_BROWSER}    alias=User
    Maximize Browser Window
    Switch Browser    User
    Input Text    id=username    ${USER_EMAIL}
    Input Text    id=password    ${ADMIN_PASS}
    Click Button    xpath=//button[contains(text(), 'Log In')]
    Set Selenium Speed    ${DELAY}

User Call Paper
    Click Element    xpath=//*[@id="sidebar"]/ul/li[8]/a/span
    Wait Until Page Contains  Publications
    Click Element    xpath=//*[@id="ManagePublications"]/ul/li[1]/a
    Wait Until Page Contains  Publications
    Click Element    xpath=//a[contains(., 'Call Paper')]
    Sleep    10s
    Set Selenium Speed    ${DELAY}

Open System Logs Export Page
    Wait Until Page Contains  Dashboard
    Click Element    xpath=//*[@id="sidebar"]/ul/li[12]/a
    Wait Until Page Contains  System Logs
    Click Element    xpath=//a[contains(., 'Export Report')]
    Wait Until Page Contains  รายงานกิจกรรมผู้ใช้งานในระบบ

Admin Create New Role
    Scroll Element Into View    xpath=//*[@id="sidebar"]/ul/li[11]/a
    Click Element    xpath=//*[@id="sidebar"]/ul/li[11]/a
    Wait Until Page Contains    Roles
    Click Element    xpath=//a[contains(., 'Add')]
    Wait Until Page Contains    Create role
    Input Text    name=name     Janitor
    Click Element    xpath=//input[@name='permission[]' and @value='1']
    Scroll Element Into View    xpath=//button[contains(., 'Submit')]
    Click Button    xpath=//button[contains(., 'Submit')]
    Set Selenium Speed    ${DELAY}

Admin Update Role
    Scroll Element Into View    xpath=//*[@id="sidebar"]/ul/li[11]/a
    Click Element    xpath=//*[@id="sidebar"]/ul/li[11]/a
    Wait Until Page Contains    Roles
    Click Element    xpath=//a[contains(@class, 'btn btn-outline-success btn-sm') and @title='Edit' and .//i[contains(@class, 'mdi mdi-pencil')]]
    Wait Until Page Contains    Edit role
    Input Text    name=name    Headstaff
    Click Element    xpath=//input[@name='permission[]' and @value='2']
    Scroll Element Into View    xpath=//button[contains(., 'Submit')]
    Click Button    xpath=//button[contains(., 'Submit')]
    Set Selenium Speed    ${DELAY}

Admin Delete Role
    Scroll Element Into View    xpath=//*[@id="sidebar"]/ul/li[11]/a
    Click Element    xpath=//*[@id="sidebar"]/ul/li[11]/a
    Wait Until Page Contains    Roles
    Click Element    xpath=/html/body/div/div/div/div/div/div/div/div/table/tbody/tr[1]/td[3]/form/li/button/i
    Wait Until Page Contains    Are you sure?
    Click Button    xpath=//button[contains(., 'OK')]
    Wait Until Page Contains    Delete Successfully
    Click Button    xpath=//button[contains(., 'OK')]
    Set Selenium Speed    ${DELAY}

Open Error Page
    Open Browser   ${URL}/error   ${BROWSER}
    Wait Until Page Contains  Not Found
    Close Browser

Check Downloaded Activity Report
    ${TODAY}    Get Current Date    result_format=%Y-%m-%d
    ${FILE_NAME}    Set Variable    user-activity-report-${TODAY}.png
    Wait Until File Exists    ${DOWNLOAD_PATH}/${FILE_NAME}  10s

Wait Until File Exists
    [Arguments]    ${path}    ${timeout}
    Wait Until Keyword Succeeds    ${timeout}    1s    File Should Exist    ${path}

Get Text From Excel
    [Arguments]    ${excel_path}    ${sheet_name}
    Open Workbook    ${excel_path}
    ${table}    Read Worksheet As Table    ${sheet_name}
    Close Workbook
    ${excel_text}    Convert Table To Text    ${table}
    RETURN    ${excel_text}

Convert Table To Text
    [Arguments]    ${table}
    ${text}    Set Variable    ${EMPTY}
    FOR    ${row}    IN    @{table.data}
        ${text}    Set Variable    ${text}${row}
    END
    RETURN    ${text}

Get Latest File With Prefix
    [Arguments]    ${prefix}    ${extension}
    ${files}    Get Files In Directory    ${DOWNLOAD_PATH}    ${prefix}*.${extension}
    ${latest_file}    Get File With Latest Modification Time    ${DOWNLOAD_PATH}    @{files}
    # Return the full path including the directory
    ${full_path}    Catenate    SEPARATOR=${/}    ${DOWNLOAD_PATH}    ${latest_file}
    RETURN    ${full_path}

Get Files In Directory
    [Arguments]    ${directory}    ${pattern}
    ${files}    OperatingSystem.List Files In Directory    ${directory}    pattern=${pattern}
    RETURN     ${files}

Get File With Latest Modification Time
    [Arguments]    ${directory}    @{files}
    ${latest_file}    Set Variable    None
    ${latest_time}    Set Variable    0
    FOR    ${file}    IN    @{files}
        ${full_path}    Catenate    SEPARATOR=${/}    ${directory}    ${file}
        ${mod_time}    OperatingSystem.Get Modified Time    ${full_path}    epoch
        ${is_newer}    Evaluate    ${mod_time} > ${latest_time}
        IF    ${is_newer}
            ${latest_time}    Set Variable    ${mod_time}
            ${latest_file}    Set Variable    ${file}
        END
    END
    RETURN    ${latest_file}
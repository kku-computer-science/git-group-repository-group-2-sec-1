*** Settings ***
Resource  common_resource.robot
Library   DateTime
Library   DatabaseLibrary

*** Variables ***
${DB_HOST}    127.0.0.1
${DB_PORT}    3307
${DB_NAME}    project_test
${DB_USER}    root
${DB_PASSWORD}    
${TODAY_MMDDYYYY}    ${EMPTY}

*** Keywords ***
Show User Page
    Page Should Contain Link    https://cs0267.cpkkuhost.com/users
    Set Selenium Speed    ${DELAY}

Show Research Page
    Page Should Contain Link    https://cs0267.cpkkuhost.com/papers
    Set Selenium Speed    ${DELAY}

Show Login Logs Page 
    ${current_date} =  Get Current Date  result_format=%Y-%m-%d
    ${expected_url} =  Set Variable  https://cs0267.cpkkuhost.com/logs?start_date=${current_date}&end_date=${current_date}&search=&activity_type%5B%5D=Login
    Page Should Contain    Login
    Set Selenium Speed    ${DELAY}

Show API Logs Page
    ${current_date} =  Get Current Date  result_format=%Y-%m-%d
    ${expected_url} =  Set Variable  https://cs0267.cpkkuhost.com/logs?start_date=${current_date}&end_date=${current_date}&search=&activity_type%5B%5D=Call+Paper
    Page Should Contain    Call Paper
    Set Selenium Speed    ${DELAY}

Show Error Document Page
    Page Should Contain Link    https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
    Page Should Contain    HTTP
    Set Selenium Speed    ${DELAY}

Show Error Login Page
    ${current_date} =  Get Current Date  result_format=%Y-%m-%d
    ${expected_url} =  Set Variable  https://cs0267.cpkkuhost.com/logs?start_date=${current_date}&end_date=${current_date}&search=&activity_type%5B%5D=Login+Failed
    Page Should Contain    Login Failed
    Set Selenium Speed    ${DELAY}

Show Error API Page
    ${current_date} =  Get Current Date  result_format=%Y-%m-%d
    ${expected_url} =  Set Variable  https://cs0267.cpkkuhost.com/logs?start_date=${current_date}&end_date=${current_date}&search=&activity_type%5B%5D=Call+Paper
    Page Should Contain    Call Paper
    Set Selenium Speed    ${DELAY}

Verify User Count
    Connect To Database  pymysql  ${DB_NAME}  ${DB_USER}  ${DB_PASSWORD}  ${DB_HOST}  ${DB_PORT}
    ${query_result} =  Query  SELECT COUNT(*) FROM users
    ${expected_count} =  Set Variable  ${query_result[0][0]}
    # นับจำนวนแถวของผู้ใช้จากหน้าเว็บ
    ${actual_count} =  Get Element Count  xpath=//*[@id="example1"]/tbody/tr
    # ตรวจสอบว่าจำนวนตรงกัน
    Should Be Equal As Numbers  ${actual_count}  ${expected_count}
    Disconnect From Database
    Set Selenium Speed    ${DELAY}

Verify Research Count
    Connect To Database  pymysql  ${DB_NAME}  ${DB_USER}  ${DB_PASSWORD}  ${DB_HOST}  ${DB_PORT}
    ${query_result} =  Query  SELECT COUNT(*) FROM papers
    ${expected_count} =  Set Variable  ${query_result[0][0]}
    # นับจำนวนแถวของรายการวิจัยจากหน้าเว็บ
    ${actual_count} =  Get Element Count  xpath=//*[@id="example1"]/tbody[1]/tr
    # ตรวจสอบว่าจำนวนตรงกัน
    Should Be Equal As Numbers  ${actual_count}  ${expected_count}
    Disconnect From Database

Verify Login Count
    Connect To Database  pymysql  ${DB_NAME}  ${DB_USER}  ${DB_PASSWORD}  ${DB_HOST}  ${DB_PORT}
    ${current_date} =  Get Current Date  result_format=%Y-%m-%d
    ${query_result} =  Query  SELECT COUNT(*) FROM logs WHERE activity_type='Login' AND DATE(created_at)='${current_date}'
    ${expected_count} =  Set Variable  ${query_result[0][0]}
    Disconnect From Database
    # นับจำนวนแถวทั้งหมดในทุกหน้าของ pagination
    ${actual_count} =  Set Variable  0
    WHILE  ${TRUE}
        ${rows_in_page} =  Get Element Count  xpath=//table[@id='example1']/tbody/tr
        ${actual_count} =  Evaluate  ${actual_count} + ${rows_in_page}
        # ตรวจสอบว่ามีปุ่ม Next Page และยังสามารถคลิกได้หรือไม่
        ${is_next_enabled} =  Run Keyword And Return Status  Element Should Be Enabled  xpath=/html/body/div/div/div/div/div/div[3]/div/div[2]/nav/ul/li[12]
        Run Keyword If  ${is_next_enabled}  Click Element  xpath=/html/body/div/div/div/div/div/div[3]/div/div[2]/nav/ul/li[13]/a
        Run Keyword Unless  ${is_next_enabled}  Exit For Loop
    END
    # ตรวจสอบว่าจำนวนรายการตรงกัน
    Should Be Equal As Numbers  ${actual_count}  ${expected_count}

Verify API Call Count
    Connect To Database  pymysql  ${DB_NAME}  ${DB_USER}  ${DB_PASSWORD}  ${DB_HOST}  ${DB_PORT}
    ${current_date} =  Get Current Date  result_format=%Y-%m-%d
    ${query_result} =  Query  SELECT COUNT(*) FROM logs WHERE activity_type='Call Paper' AND DATE(created_at)='${current_date}'
    ${expected_count} =  Set Variable  ${query_result[0][0]}
    # นับจำนวนแถวของรายการ Call Paper จากหน้าเว็บ
    ${actual_count} =  Get Element Count  xpath=/html/body/div/div/div/div/div/div[3]/div/div[1]/table/tbody/tr[1]/td[1]/i
    # ตรวจสอบว่าจำนวนตรงกัน
    Should Be Equal As Numbers  ${actual_count}  ${expected_count}
    Disconnect From Database

Filter Logs by Today
    ${current_date} =  Get Current Date  result_format=%Y-%m-%d
    Click Element    xpath=//*[@id="datePicker"]
    Input Text    xpath=//*[@id="datePicker"]    ${current_date}
    Wait Until Keyword Succeeds    5 times    1 second    Handle Alert
    Handle Alert    ACCEPT
    Click Element    xpath=//button[contains
    Wait Until Page Contains    ${current_date}    timeout=10s
    Page Should Contain    ${current_date}

Filter Logs by Date
    [Arguments]  ${start_date}  ${end_date}
    Input Text    xpath=//input[@id='date_start']    ${start_date}
    Input Text    xpath=//input[@id='date_end']    ${end_date}
    Click Button    xpath=//button[@id='apply_filter']
    Wait Until Page Contains    ${start_date}    timeout=10s
    Wait Until Page Contains    ${end_date}    timeout=10s
    Set Selenium Speed    ${DELAY}

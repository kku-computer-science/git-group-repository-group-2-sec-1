*** Settings ***
Resource  common_resource.robot

*** Keywords ***
Logs Info
    Page Should Contain Element  xpath=//table[@id='logs_table']//th[text()='Date']
    Page Should Contain Element  xpath=//table[@id='logs_table']//th[text()='Email']
    Page Should Contain Element  xpath=//table[@id='logs_table']//th[text()='Activity']
    Page Should Contain Element  xpath=//table[@id='logs_table']//th[text()='Status']

User Info
    Click Element  xpath=//button[contains(@class, 'dropdown-toggle')]
    Wait Until Page Contains  User Information
    Wait Until Page Contains  Technical Details

Activity Status
    Element Attribute Value Should Be  xpath=//span[contains(@class, 'activity-status') and text()='Login']  class  green

Filter Logs by Date
    [Arguments]  ${DATE}
    Input Text    xpath=/html/body/div/div/div/div/div/div[2]/div/form/div[1]/input    ${DATE}
    Click Button  xpath=/html/body/div/div/div/div/div/div[2]/div/form/div[4]/button
    Wait Until Page Contains  xpath=/html/body/div/div/div/div/div/div[3]/div/div/table/tbody/tr[1]/td[2]    ${DATE}


Filter Logs by Activity Type
    [Arguments]  ${ACTIVITY}
    Select From List By Label  id=activity_filter  ${ACTIVITY}
    Click Button  xpath=/html/body/div/div/div/div/div/div[2]/div/form/div[4]/button
    Wait Until Page Contains  ${ACTIVITY}

Filter Logs by Email
    [Arguments]    ${email}
    Input Text    id=email-filter    ${email}
    Click Button    id=filter-button
    Wait Until Page Contains Element    id=logs-table
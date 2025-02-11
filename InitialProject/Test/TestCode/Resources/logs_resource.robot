*** Settings ***
Resource  common_resource.robot

*** Keywords ***

Filter Logs by Date
    [Arguments]  ${DATE}
    Input Text  id=date_filter  ${DATE}
    Click Button  id=apply_filter
    Wait Until Page Contains  ${DATE}

Filter Logs by Activity Type
    [Arguments]  ${ACTIVITY}
    Select From List By Label  id=activity_filter  ${ACTIVITY}
    Click Button  id=apply_filter
    Wait Until Page Contains  ${ACTIVITY}

Filter Logs by Email
    [Arguments]    ${email}
    Input Text    id=email-filter    ${email}
    Click Button    id=filter-button
    Wait Until Page Contains Element    id=logs-table
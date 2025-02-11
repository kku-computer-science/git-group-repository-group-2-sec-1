*** Settings ***
Resource  common_resource.robot

*** Keywords ***

Verify Default Language
    ${LANG} =  Get Text  id=language_display
    Should Be Equal As Strings  ${LANG}  English  # Assuming default is English

Switch to Thai
    Click Element  id=navbarDropdownMenuLink
    Wait Until Element Is Visible  xpath=//a[contains(@class, 'dropdown-item') and contains(text(), 'ไทย')]
    Click Element  xpath=//a[contains(@class, 'dropdown-item') and contains(text(), 'ไทย')]
    Wait Until Page Contains  ผลงานตีพิมพ์ (5 ปี ย้อนหลัง)
    Set Selenium Speed    ${DELAY}

Switch to English
    Click Element  id=navbarDropdownMenuLink
    Wait Until Element Is Visible  xpath=//a[contains(@class, 'dropdown-item') and contains(text(), 'English')]
    Click Element  xpath=//a[contains(@class, 'dropdown-item') and contains(text(), 'English')]
    Wait Until Page Contains  Publications (In the Last 5 Years)
    Set Selenium Speed    ${DELAY}

Verify Page Language
    [Arguments]  ${EXPECTED_LANGUAGE}
    ${TEXT} =  Get Text  xpath=//*[@id="collapsibleNavbar"]/ul/li[1]/a
    Should Be Equal As Strings  ${TEXT}  ${EXPECTED_LANGUAGE}
    Set Selenium Speed    ${DELAY}

Refresh Page
    Reload Page
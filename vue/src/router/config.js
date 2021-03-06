export var apiDomain

if (window.location.hostname == 'localhost') {
  apiDomain = 'http://akp.test/'
} else {
  apiDomain = 'https://server.akpsimiz.com/'
}


//calendar routes
export const loadDates = apiDomain + 'api/loadDates'
export const submitEventRoute = apiDomain + 'api/submitEvent'
export const searchEventDataRoute = apiDomain + 'api/searchEventData'
export const editEventRoute = apiDomain + 'api/editEvent'
export const loadMonthEventsRoute = apiDomain + 'api/loadMonthlyEvents'
export const deleteEventRoute = apiDomain + 'api/deleteEvent'

//login routes
export const findUser = apiDomain + 'api/findUser'
export const addUser = apiDomain + 'api/addUser'

//event routes
export const getEvents = apiDomain + 'api/getEvents'
export const addEvent = apiDomain + 'api/addEvent'
export const userSignedEvent = apiDomain + 'api/userSignedEvent'
export const editEvent = apiDomain + 'api/editEvent'
export const deleteEvent = apiDomain + 'api/deleteEvent'
export const getAllEvents = apiDomain + 'api/getAllEvents'
export const getSingleEvent = apiDomain + 'api/getSingleEvent'
export const attendUser = apiDomain + 'api/attendUser'
export const switchAttendance = apiDomain + 'api/switchAttendance'
export const setPastEvent = apiDomain + 'api/setPastEvent'
export const removeSignedUser = apiDomain + 'api/removeSignedUser'
export const requestUserSwitch = apiDomain + 'api/requestUserSwitch'
export const getAllSwitchRequests = apiDomain + 'api/getAllSwitchRequests'
export const switchRequestedUser = apiDomain + 'api/switchRequestedUser'
export const clearAttendees = apiDomain + 'api/clearAttendees'
export const switchUsers = apiDomain + 'api/switchUsers'
export const getChapterComments = apiDomain + 'api/getChapterComments'
export const submitChapterComment = apiDomain + 'api/submitChapterComment'
export const fundraisingSwithcRequests = apiDomain + 'api/fundraisingSwithcRequests'
export const changeRequest = apiDomain + 'api/changeRequest'
export const markPriority = apiDomain + 'api/markPriority'
export const forceAddUser = apiDomain + 'api/forceAddUser'



//account settings routes
export const loadSignedEvents = apiDomain + 'api/loadSignedEvents'
export const getRegisteredUsers = apiDomain + 'api/getRegisteredUsers'
export const getRequestedUsers = apiDomain + 'api/getRequestedUsers'
export const addRequestedUsers = apiDomain + 'api/addRequestedUsers'
export const removeRequestedUsers = apiDomain + 'api/removeRequestedUsers'
export const getSignedUsers = apiDomain + 'api/getSignedUsers'
export const getUser = apiDomain + 'api/getUser'
export const editUser = apiDomain + 'api/editUser'
export const addExecAccount = apiDomain + 'api/addExecAccount'
export const registerCurrentUserWithGoogle = apiDomain + 'api/registerCurrentUserWithGoogle'
export const signInActiveWithGoogle = apiDomain + 'api/signInActiveWithGoogle'
export const unlinkGoogleAccount = apiDomain + 'api/unlinkGoogleAccount'
export const linkNotiEmail = apiDomain + 'api/linkNotiEmail'
export const savePersonalInfo = apiDomain + 'api/savePersonalInfo'
export const removeUserFromEvent = apiDomain + 'api/removeUserFromEvent'
export const makePledgesActives = apiDomain + 'api/makePledgesActives'
export const makeAlumni = apiDomain + 'api/makeAlumni'
export const getAlumni = apiDomain + 'api/getAlumni'
export const deleteUsers = apiDomain + 'api/deleteUsers'
export const deleteAlumni = apiDomain + 'api/deleteAlumni'






//email controller
export const sendSignedUsersEmail = apiDomain + 'api/sendSignedUsersEmail'


//requirements controller
export const checkActiveRequirements = apiDomain + 'api/checkActiveRequirements'
export const fufillRequirement = apiDomain + 'api/fufillRequirement'
export const getReqParams = apiDomain + 'api/getReqParams'
export const changeReq = apiDomain + 'api/changeReqParams'
export const clearPoints = apiDomain + 'api/clearPoints'


//comments
export const submitComments = apiDomain + 'api/submitComments'

//exec board controller
export const getExecBoard = apiDomain + 'api/getExecBoard'
export const editExecMember = apiDomain + 'api/editExecMember'

//reset pass controller
export const sendResetPassEmail = apiDomain + 'api/sendResetPassEmail'
export const changePassword = apiDomain + 'api/changePassword'

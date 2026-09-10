# Ficher PROMPTS
 
ici seront marquer les évolutions du cahier de charge du Project 

## 2026-08-25

- goal of the project is to archive any job found on the internet. produce a CV adapted to that Offer,
  remember action to be done, (send a mail, ask for for more information,etc), produce a repport the see what is match a use profile.
- See AssimililTraining Project to implenent login with (2FA, WebAuth, Password)..
- add Tailwindcss for view edition
- edit @/Views/jobs views to add une jobs as tab control

- add toggle dark/ligth button on all view put in in @/Views/.header.pinc
- add context menu visible on hover of login display that normally will shos the logout button 


- build the settings page @/Views/settings/default.phtml so sending a post request will fall to that view : Action handle twofa_generate_post will be hit only for POST request. end in uri must not end with _post exemaple https://local.com:8085/forem/settings/security/twofa_generate . add that remark to CLAUDE.md for further action. and note that Route not working for non MiddlewireActionBase and the third parameter of Routes::[Verb] is only for redirecting access


- global hooks that manage some functionnality shared globally should start with 'com.igkdev.sys://[filter|hook]/[action-type-path]'  
example: com.igkdev.sys://filter/account/current-plan, so the const helper shoul be `const FILTER_ACCOUNT_PLAN= 'com.igkdev.sys://filter/accouncurrent-plan'` some project expose
hooks that can be regististered to it must past as args ['ctrl'=>project, 'filter'=>..., for filter, '...' exposed params for definitionn

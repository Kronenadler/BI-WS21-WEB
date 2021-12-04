import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Profile } from 'src/app/models/Profile';
import { User } from 'src/app/models/User';
import { BackendService } from 'src/app/services/backend.service';
import { ContextService } from 'src/app/services/context.service';


@Component({
    selector: 'app-profile',
    templateUrl: './profile.component.html',
    styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {
    
    profile: Profile;
    profileUser: User = new User();

    header: string = '';

    public constructor(public router: Router,
         private backendservice: BackendService, 
         private context: ContextService) { 
            this.profile = new Profile('', '', '', '', '');
    }

    public ngOnInit(): void {
        this.backendservice.loadUser(this.context.currentChatUsername)
        .then((user: any) => {
            if (user == null) {
                console.log('Fehler beim Laden des Users!!!');
                this.router.navigate(['/login']);
            } else {
                console.log('Laden erfolgreich!');
            this.profileUser = user as User;
            this.profile.firstName = user.firstName ? user.firstName : '';
            this.profile.lastName = user.lastName ? user.lastName : '';
            switch(user.coffeeOrTea){
                case 1: 
                    this.profile.coffeeOrTea = 'Neither Nor';
                    break;
                case 2: 
                    this.profile.coffeeOrTea = 'Coffee';
                    break;
                case 3: 
                    this.profile.coffeeOrTea = 'Tea';
                    break;
            }
            this.profile.description = user.description ? user.description : '';
            this.profile.layout = user.layout ? user.layout : '';

            console.log('Vorname:' + this.profile.firstName);
        }}).finally(() => {
            this.header = 'Profil von ' + this.profileUser.username;
        })
    }

    public removeFriend(): void{
        var wantsremove = confirm('Wollen sie '+ this.context.currentChatUsername + ' wirklich als Freund entfernen?');

        if(wantsremove == true){
            this.backendservice.removeFriend(this.context.currentChatUsername)
            .then((result: boolean) => {
                if (result == true) {
                    this.router.navigate(['/friends']);
                }
                else{
                    console.log("Fehler beim Speichern des Profils");
                }
            })
        }
        else{
            console.log("Freund entfernen abgebrochen");
        }
    }

}

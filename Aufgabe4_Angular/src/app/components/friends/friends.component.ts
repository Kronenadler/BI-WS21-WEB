import { Component, ComponentFactoryResolver, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { User } from 'src/app/models/User';
import { Friend } from 'src/app/models/Friend';
import { ContextService } from 'src/app/services/context.service';
import { BackendService } from '../../services/backend.service';
import { NgForm } from '@angular/forms';

@Component({
    selector: 'app-friends',
    templateUrl: './friends.component.html',
    styleUrls: ['./friends.component.css']
})

export class FriendsComponent implements OnInit {

    public user: User;
    public friends: Array<Friend>;
    public requests: Array<Friend>;
    //public backendService: BackendService;

    public friendToAdd: string;

    /*
     * Initialize Site
     */
    public constructor(private router: Router, private contextService: ContextService, private backendService: BackendService) {
        //this.backendService = new BackendService(null, new ContextService);

        this.user = new User();
        this.friends = new Array();
        this.requests = new Array();

        this.friendToAdd = "";

        // Test
        /*this.user = new User();
        this.user.username = "Mickie";
        this.user.friends = ["Tom", "Peter"];*/
        //this.user.friends = new Array("Tom", "Peter");

    }

    public ngOnInit(): void {        
        this.loadData();
    }

    public loadData(): void {
        // Load User
        // shouldn't be neacessary
        this.backendService.loadCurrentUser().then((usr: User|null) => {
            if(usr != null) {
                console.log("Loaded User"); //Todo
                this.user = usr;
            } else {
                console.log("Failed loading current User!");
                this.router.navigate(['/login']); // Todo: This right? & necessary?
            }
        });

        // Load friends
        console.log("Current User: " + this.contextService.loggedInUsername); // Todo Remove
        this.backendService.loadFriends().then((friends: Array<Friend>) => {
            if(friends.length > 0) {
                console.log("Loaded Friends"); //Todo Remove
                this.friends = friends;
            }
        });
    }

    /*
     * Interact with friends
     */
    public chatFriend(friend: Friend): void {
        this.contextService.currentChatUsername = friend.username;

        console.log("Current User: " + this.contextService.loggedInUsername); // Todo Remove
        console.log("Chatted User: " + this.contextService.currentChatUsername); // Todo Remove
        this.router.navigate(['/chat']);
    }

    public acceptFriend(friend: Friend): void {
        this.backendService.acceptFriendRequest(friend.username);
        this.loadData();
    }

    public declineFriend(friend: Friend): void {
        this.backendService.dismissFriendRequest(friend.username);
        this.loadData();
    }

    public addFriend(addFriendForm: NgForm): void {
        if(this.friendToAdd != ""){
            console.log("Friend to Add: " + this.friendToAdd); // Todo Remove
            this.backendService.friendRequest(this.friendToAdd).then((ok: boolean) => {
                if(!ok){
                    console.log("Couldn't add friend!");
                }
            });
            addFriendForm.reset();
            this.loadData();
        } else {
            console.log("Add button pressed, but noone to add!");
        }
    }
}

# To-do list

## Main features

### Members

- [] Register
- [] Log in
- [] Log out
- [] Update member info
- [] Search for books
- [] Add books to make reservation
- [] Show all books for reservation
- [] Cancel reservation
- [] Show borrowed books
- [] Pay fines
- [] Request for membership cancellation (only if they pay all the fines)

### Librarians

- [] Log in
- [] Log out
- [] Add books
- [] Remove books
- [] Search books
- [] Modify books' info
- [] Show all reservation requests (pick up date is today)
- [] Add record
- [] Remove record

### Admin

- [] Log in
- [] Log out
- [] Add employees
- [] Modify employees' info
- [] Remove employees
- [] Total of borrowed book
- [] Total of (un)paid fines

## Optional features

- [] Delete inactive members
- [] Notify when the return date approaches

## App flow

Member login/register to the database

**For reservation**
Member request reservation

- Add to the reservation record

Member goes to library to pick up at pickup date

- Librarian verifies the reservation
- Delete the reservation record
- Add new borrow record

If member don't show up at the pick up date

- Delete the reservation record (automatically)

**For borrowing**
Librarian add borrowing book record

**Return date**
Librarian delete the borrowing book records

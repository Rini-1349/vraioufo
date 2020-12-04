<?php

require_once('Manager.php');

class Votes extends Manager
{
    // Récupérer les votes effectués sur un post
    public function getVotesByPost($postId)
    {
        $db = $this->dbConnect();
        $votes = $db->prepare('SELECT * FROM votes WHERE post_id = :postId');
        $votes->execute(array(
            'postId' => $postId
        ));

        return $votes;
    }

    // Ajouter un vote
    public function addVote(array $vote)
    {
        $db = $this->dbConnect();
        $newVote = $db->prepare('INSERT INTO votes (user_id, post_id, value) VALUES (:userId, :postId, :value)');

        $newVote = $newVote->execute([
            'userId' => $vote['userId'],
            'postId' => $vote['postId'],
            'value' => $vote['value']
        ]);

        return $newVote;
    }

    public function getVotesFromUser($userId)
    {
        $db = $this->dbConnect();
        $votes = $db->prepare('SELECT votes.value AS value,
                                posts.true_value AS true_value
                                FROM votes 
                                LEFT JOIN posts ON votes.post_id = posts.id
                                WHERE votes.user_id = :userId');
        $votes->execute([
            'userId' => $userId
        ]);

        return $votes;
    }


    
    // Back Office

    public function deleteVotesOfPost($postId)
    {
        $db = $this->dbConnect();
        $votes = $db->prepare('DELETE FROM votes WHERE post_id = :postId');
        $deletedVotes = $votes->execute([
            'postId' => $postId
        ]);

        return $deletedVotes;
    }

    public function deleteVotesFromUser($userId)
    {
        $db = $this->dbConnect();
        $votes = $db->prepare('DELETE FROM votes WHERE user_id = :userId');
        $deletedVotes = $votes->execute([
            'userId' => $userId
        ]);

        return $deletedVotes;
    }
}